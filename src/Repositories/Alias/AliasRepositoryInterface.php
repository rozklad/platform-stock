<?php namespace Sanatorium\Stock\Repositories\Alias;

interface AliasRepositoryInterface {

	/**
	 * Returns a dataset compatible with data grid.
	 *
	 * @return \Sanatorium\Stock\Models\Alias
	 */
	public function grid();

	/**
	 * Returns all the stock entries.
	 *
	 * @return \Sanatorium\Stock\Models\Alias
	 */
	public function findAll();

	/**
	 * Returns a stock entry by its primary key.
	 *
	 * @param  int  $id
	 * @return \Sanatorium\Stock\Models\Alias
	 */
	public function find($id);

	/**
	 * Determines if the given stock is valid for creation.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForCreation(array $data);

	/**
	 * Determines if the given stock is valid for update.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForUpdate($id, array $data);

	/**
	 * Creates or updates the given stock.
	 *
	 * @param  int  $id
	 * @param  array  $input
	 * @return bool|array
	 */
	public function store($id, array $input);

	/**
	 * Creates a stock entry with the given data.
	 *
	 * @param  array  $data
	 * @return \Sanatorium\Stock\Models\Alias
	 */
	public function create(array $data);

	/**
	 * Updates the stock entry with the given data.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Sanatorium\Stock\Models\Alias
	 */
	public function update($id, array $data);

	/**
	 * Deletes the stock entry.
	 *
	 * @param  int  $id
	 * @return bool
	 */
	public function delete($id);

}
