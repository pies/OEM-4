<?php
namespace OEM;

trait Cached {
	
	/**
	 * @var \Memcache
	 */
	private $cache;
	
	/**
	 * @var int
	 */
	private $cacheExpire;

	/**
	 * @var string
	 */
	protected $cacheKey;
	
	public function initCache(\Memcache $cache, $expire=3600) {
		$this->cache = $cache;
		$this->cacheExpire = $expire;
	}

	protected function getCache() {
		return $this->cache->get($this->cacheKey);
	}
	
	protected function setCache($value) {
		return $this->cache->set($this->cacheKey, $value, $this->cacheExpire);
	}

}
