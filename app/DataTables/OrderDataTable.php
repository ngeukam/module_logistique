<?php
/**
 * File name: OrderDataTable.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\DataTables;

use App\Models\CustomField;
use App\Models\Order;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
{
    /**
     * custom fields columns
     * @var array
     */
    public static $customFields = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $columns = array_column($this->getColumns(), 'data');
        $dataTable = $dataTable
            ->editColumn('id', function ($order) {
                return "#".$order->id;
            })
            ->editColumn('updated_at', function ($order) {
                return getDateColumn($order, 'updated_at');
            })
            ->editColumn('order_locations_status', function ($order) {
                return getOrderLocations($order->orderLocationsStatus,'locations_status');
            })
            ->editColumn('payment.status', function ($order) {
                return getPayment($order->payment,'status');
            })
            ->editColumn('active', function ($product) {
                return getBooleanColumn($product, 'active');
            })
            ->addColumn('action', 'orders.datatables_actions')
            ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            [
                'data' => 'id',
                'title' => trans('lang.order_id'),

            ],
            [
                'data' => 'user.name',
                'name' => 'user.name',
                'title' => trans('lang.order_user_id'),

            ],
            [
                'data' => 'order_status.status',
                'name' => 'orderStatus.status',
                'title' => trans('lang.order_order_status_id'),

            ],
            [
                'data' => 'order_locations_status',
                'name' => 'order_locations_status',
                'title' => trans('lang.order_order_locations_statuses_id'),
            ],

            [
                'data' => 'type_product',
                'title' => trans('lang.order_type_product'),
            ],

            [
                'data' => 'departure_address',
                'title' => trans('lang.order_departure_address'),
            ],

            [
                'data' => 'arrival_address',
                'title' => trans('lang.order_arrival_address'),
            ],

            /*[
                'data' => 'tax',
                'title' => trans('lang.order_tax'),
                'searchable' => false,

            ],
            [
                'data' => 'delivery_fee',
                'title' => trans('lang.order_delivery_fee'),
                'searchable' => false,

            ],*/
            [
                'data' => 'payment.status',
                'name' => 'payment.status',
                'title' => trans('lang.payment_status'),

            ],
            [
                'data' => 'payment.method',
                'name' => 'payment.method',
                'title' => trans('lang.payment_method'),

            ],
            [
                'data' => 'active',
                'title' => trans('lang.order_active'),

            ],
            /*[
                'data' => 'updated_at',
                'title' => trans('lang.order_updated_at'),
                'searchable' => false,
                'orderable' => true,

            ]*/
        ];

        $hasCustomField = in_array(Order::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', Order::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.order_' . $field->name),
                    'orderable' => false,
                    'searchable' => false,
                ]]);
            }
        }
        return $columns;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        if(auth()->user()->country=='CI'){
            if (auth()->user()->hasRole('admin')) {
                return $model->newQuery()->with("user")->with("orderStatus")->with('payment')->with("orderLocationsStatus")
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->where('users.country','=','CI')
                    ->select('orders.*');
            } else if (auth()->user()->hasRole('manager')) {
                //return $model->newQuery()->with("user")->with("orderStatus")->with('payment');
                return $model->newQuery()->with("user")->with("orderStatus")->with('payment')->with("orderLocationsStatus")
                    ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->where('users.country','=','CI')
                    ->where('order_statuses.status', '!=', 'Ready')
                    ->where('orders.active', '=', 1)
                    ->select('orders.*');
                /*return $model->newQuery()->with("user")->with("orderStatus")->with('payment')
                    ->join("product_orders", "orders.id", "=", "product_orders.order_id")
                    ->join("products", "products.id", "=", "product_orders.product_id")
                    ->join("user_markets", "user_markets.market_id", "=", "products.market_id")
                    ->where('user_markets.user_id', auth()->id())
                    ->groupBy('orders.id')
                    ->select('orders.*');*/
            } else if (auth()->user()->hasRole('client')) {
                return $model->newQuery()->with("user")->with("orderStatus")->with('payment')->with("orderLocationsStatus")
                    ->where('orders.user_id', auth()->id())
                    ->where('orders.active', '=', 1)
                    ->groupBy('orders.id')
                    ->select('orders.*');
            } else if (auth()->user()->hasRole('driver')) {
                return $model->newQuery()->with("user")->with("orderStatus")->with('payment')->with("orderLocationsStatus")
                    ->where('orders.driver_id', auth()->id())
                    ->groupBy('orders.id')
                    ->select('orders.*');
            } else {
                return $model->newQuery()->with("user")->with("orderStatus")->with('payment')->with("orderLocationsStatus");
            }
        }
        if(auth()->user()->country=='CM'){
            if (auth()->user()->hasRole('admin')) {
                return $model->newQuery()->with("user")->with("orderStatus")->with('payment')->with("orderLocationsStatus")
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->where('users.country','=','CM')
                    ->select('orders.*');
            } else if (auth()->user()->hasRole('manager')) {
                //return $model->newQuery()->with("user")->with("orderStatus")->with('payment');
                return $model->newQuery()->with("user")->with("orderStatus")->with('payment')->with("orderLocationsStatus")
                    ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->where('users.country','=','CM')
                    ->where('orders.active', '=', 1)
                    ->where('order_statuses.status', '!=', 'Ready')
                    ->select('orders.*');
                /*return $model->newQuery()->with("user")->with("orderStatus")->with('payment')
                    ->join("product_orders", "orders.id", "=", "product_orders.order_id")
                    ->join("products", "products.id", "=", "product_orders.product_id")
                    ->join("user_markets", "user_markets.market_id", "=", "products.market_id")
                    ->where('user_markets.user_id', auth()->id())
                    ->groupBy('orders.id')
                    ->select('orders.*');*/
            } else if (auth()->user()->hasRole('client')) {
                return $model->newQuery()->with("user")->with("orderStatus")->with('payment')->with("orderLocationsStatus")
                    ->where('orders.user_id', auth()->id())
                    ->where('orders.active', '=', 1)
                    ->groupBy('orders.id')
                    ->select('orders.*');
            } else if (auth()->user()->hasRole('driver')) {
                return $model->newQuery()->with("user")->with("orderStatus")->with('payment')->with("orderLocationsStatus")
                    ->where('orders.driver_id', auth()->id())
                    ->groupBy('orders.id')
                    ->select('orders.*');
            } else {
                return $model->newQuery()->with("user")->with("orderStatus")->with('payment')->with("orderLocationsStatus");
            }
        }

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['title'=>trans('lang.actions'),'width' => '80px', 'printable' => false, 'responsivePriority' => '100'])
            ->parameters(array_merge(
                [
                    'language' => json_decode(
                        file_get_contents(base_path('resources/lang/' . app()->getLocale() . '/datatable.json')
                        ), true),
                    'order' => [ [0, 'desc'] ],
                ],
                config('datatables-buttons.parameters')
            ));
    }

    /**
     * Export PDF using DOMPDF
     * @return mixed
     */
    public function pdf()
    {
        $data = $this->getDataForPrint();
        $pdf = PDF::loadView($this->printPreview, compact('data'));
        return $pdf->download($this->filename() . '.pdf');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ordersdatatable_' . time();
    }
}