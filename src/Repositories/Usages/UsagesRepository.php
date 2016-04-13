<?php namespace Sanatorium\Stock\Repositories\Usages;


class UsagesRepository implements UsagesRepositoryInterface {

	/**
     * Array of registered namespaces.
     *
     * @var array
     */
    protected $services;

    /**
     * {@inheritDoc}
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * {@inheritDoc}
     */
    public function registerService($key, $service)
    {
        $this->services[$key] = $service;
    }

}
