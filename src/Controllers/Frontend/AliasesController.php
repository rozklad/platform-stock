<?php namespace Sanatorium\Stock\Controllers\Frontend;

use Platform\Foundation\Controllers\Controller;

class AliasesController extends Controller {

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('sanatorium/stock::index');
	}

}
