<?php namespace Sanatorium\Stock\Traits;

use Sanatorium\Stock\Models\Alias;

trait StockTrait {

	public function getAvailabilitySlugAttribute()
	{
		return str_slug( $this->availability );
	}

	public function getAvailabilityAttribute()
	{
		return $this->getAvailability('default')->alias;
	}

	public function getAvailableForBuyAttribute()
	{
		return $this->getAvailability('default')->available;
	}

	public function getAvailability($usage = 'default')
	{
		$stock = $this->stock;
		
		$alias = Alias::where('min', '<=', $stock)
						->where(function($q) use ($stock) {
							return $q->where('max', '>=', $stock)
		              			->orWhere('max', '=', '0');
						} )
		              ->where('usage', $usage)
		              ->orderBy('min', 'DESC')
		              ->first();

		if ( $alias ) {
			return $alias;
		}

		return $this->fallbackAlias();
	}

	public function fallbackAlias()
	{
		return new Alias;
	}

}