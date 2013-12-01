<?php
namespace OEM\Model\Mongo;

abstract class Index extends \OEM\Model\Index implements \Iterator {

	public $page = 1;
	public $limit = 10;
	public $sort = ['created' => -1];
	
	/**
	 * @var \MongoCursor
	 */
	protected $cursor;
	
	public function __construct($page=1) {
		$this->page = $page;
		$this->cursor = $this->get();
	}

	abstract protected function collection();
	
	public function get() {
		$skip = ($this->page - 1) * $this->limit;
		return $this->collection()->find()
			->sort($this->sort)
			->limit($this->limit)
			->skip($skip);
	}

}
