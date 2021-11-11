<?php

namespace App\Criteria\Orders;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrdersOfLocationsStatusesCriteria.
 *
 * @package namespace App\Criteria\Orders;
 */
class OrdersOfLocationsStatusesCriteria implements CriteriaInterface
{
    /**
     * @var array
     */
    private $request;

    /**
     * OrdersOfStatusesCriteria constructor.
     * @param array $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (!$this->request->has('locations_statuses')) {
            return $model;
        } else {
            $locations_statuses = $this->request->get('locations_statuses');
            if (in_array('0', $locations_statuses)) { // means all locations_statuses
                return $model;
            }
            return $model->whereIn('order_locations_status_id', $this->request->get('locations_statuses', []));
        }
    }
}
