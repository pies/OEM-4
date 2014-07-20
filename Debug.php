<?php
namespace OEM;

class Debug {
	
	/**
	 * Pretty-prints a variable.
	 * 
	 * @param mixed $var Variable to print
	 */
	public static function show($var) {
		$title = join(' &rarr; ', self::place());
		$vars = func_get_args();
		$marker = '/*HLMK*/';
		foreach ($vars as $var) {
			if (ini_get('html_errors')) {
				$tmp = highlight_string("<?php\n{$marker}".print_r($var, true), true);
				$pos = strpos($tmp, $marker.'</span>') + strlen($marker.'</span>');
				$str = trim(substr($tmp, $pos, -7));
			}
			else {
				$str = print_r($var, true);
			}
				
			self::output($str, $title);
		}
	}

	/**
	 * Prints a formatted log message with a timestamp.
	 * 
	 * @param string $msg The message to display
	 */
	public static function msg($msg) {
		$html = (bool) ini_get('html_errors');
		$mt = microtime(true);
		$ms = sprintf('%-04s', substr($mt, strpos($mt, '.') + 1));
		$timestamp = date('H:i:s').".{$ms}";
		if ($html) {
			output(str_replace(array('[',']'), array('<b>', '</b>'), $msg), $timestamp, '#DDD');
		}
		else {
			echo "{$timestamp} {$msg}\n";
		}
	}
	
	/**
	 * Returns an array of fixed and shortened backtrace positions.
	 * 
	 * @return array An array of backtrace positions
	 */
	public static function place($skip=2) {
		$places = array();
		$first = true;
		foreach(debug_backtrace() as $trace) {
			if ($first) {
				$first = false;
				continue;
			}
			if ($skip) {
				$skip--;
				continue;
			}
			if (empty($trace['file'])) {
				continue;
			}
			$places[] = self::prettyPath($trace['file'], $trace['line']);
		}
		return $places;
	}
	
	/**
	 * Prettifies the file path.
	 * 
	 * @param string $path
	 * @param int $line
	 * @return string
	 */
	private static function prettyPath($path, $line=false) {
		$path = str_replace('\\', '/', $path);
		$shortPath = str_replace(APP_ROOT_DIR, '', $path);
		$file = basename($path);
		return str_replace($file, "<b>{$file}</b>", $shortPath).($line? ":{$line}": '');
	}

	/**
	 * Prints a CSS-independent text frame.
	 * 
	 * @param string $msg Main message
	 * @param string $title Message title
	 * @param string $color Frame color as CSS hex (i.e. #F80)
	 * @param string $tag HTML tag to use for the content frame
	 */
	private static function output($msg, $title=false, $color='#F88', $tag='pre') {
		$plain = !ini_get('html_errors');

		if ($plain) {
			$decode = function($str) {
				return html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
			};
			$dot = $decode('&rsaquo;');
			$title = $decode(strip_tags($title));
			$msg = $decode($msg);
			echo "\n{$dot}{$dot}{$dot} {$title}\n{$msg}\n{$dot}{$dot}{$dot}\n\n";
		}
		else {
			$title = $title? "<span style=\"font-size:12px;background-color:#FFC;color:#555\">{$title}</span>\n": "";
			$style = <<<CSS
	background-color:#FAFAF4;
	color:#000;
	padding:.4em .5em;
	border:2px solid {$color};
	margin-bottom:1em;
	font-size:14px;
	font-family:Consolas,monospace;
	line-height:120%;
CSS;
			$tagHtml = ($tag == 'pre')? "pre style=\"{$style}\"": $tag;
			echo "<{$tagHtml}>{$title}{$msg}</{$tag}>";
		}
	}

}