<?php namespace Sanatorium\Stock\Controllers\Admin;

use Platform\Access\Controllers\AdminController;
use Sanatorium\Stock\Repositories\Alias\AliasRepositoryInterface;
use Sanatorium\Stock\Repositories\Usages\UsagesRepositoryInterface;
use DB;

class StockController extends AdminController {

    /**
     * {@inheritDoc}
     */
    protected $csrfWhitelist = [
        'executeAction',
    ];

    /**
     * The Stock repository.
     *
     * @var \Sanatorium\Stock\Repositories\Alias\AliasRepositoryInterface
     */
    protected $aliases;

    /**
     * Holds all the mass actions we can execute.
     *
     * @var array
     */
    protected $actions = [
        'delete',
        'enable',
        'disable',
    ];

    /**
     * Constructor.
     *
     * @param  \Sanatorium\Stock\Repositories\Alias\AliasRepositoryInterface  	$aliases
     * @param  \Sanatorium\Stock\Repositories\Usages\UsagesRepositoryInterface  $usages
     * @return void
     */
    public function __construct(AliasRepositoryInterface $aliases,
                                UsagesRepositoryInterface $usages)
    {
        parent::__construct();

        $this->usages = $usages;

        $this->aliases = $aliases;
    }

    /**
     * Display a listing of alias.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('sanatorium/stock::index');
    }

    public function action($type = null)
    {

        switch ( $type ) {

            case 'minimal':

                    DB::table('shop_products')
                        ->update(['stock' => 1]);

                    $this->alerts->success(trans("sanatorium/stock::common.action.{$type}_success"));

                    return redirect()->back();

                break;

            case 'not_available':

                    DB::table('shop_products')
                        ->update(['stock' => 0]);

                    $this->alerts->success(trans("sanatorium/stock::common.action.{$type}_success"));

                    return redirect()->back();

                break;

        }
    }

}
