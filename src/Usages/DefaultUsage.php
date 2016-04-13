<?php namespace Sanatorium\Stock\Usages;


class DefaultUsage {

	public $slug 			= 'default';
	public $extension 		= 'stock';

	public $name 			= null;
	public $description 	= null;

	public function __construct()
	{
		$this->name 		= trans('sanatorium/'.$this->extension.'::usage/default.name');
		$this->description 	= trans('sanatorium/'.$this->extension.'::usage/default.description');
	}

}
