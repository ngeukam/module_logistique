<?php

namespace App\Criteria\Orders;

use App\Models\User;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class NotPaidOrderCriteria.
 *
 * @package namespace App\Criteria\Orders;
 */
class NotPaidOrderCriteria implements CriteriaInterface
{

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
        if (auth()->user()->hasRole('admin')) {
            return $model->where('payments.status', "=", 'Waiting for Client');
        }
    }
}
