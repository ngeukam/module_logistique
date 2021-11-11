<?php

namespace App\Repositories;

use App\Models\Order;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OrderRepository
 * @package App\Repositories
 * @version August 31, 2019, 11:11 am UTC
 *
 * @method Order findWithoutFail($id, $columns = ['*'])
 * @method Order find($id, $columns = ['*'])
 * @method Order first($columns = ['*'])
*/
class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'order_status_id',
        'tax',
        'hint',
        'payment_id',
        'delivery_address_id',
        'active',
        'driver_id',
        'type_product',
        'masse',
        'departure_address',
        'arrival_address',
        'number_truck',
        'type_truck',
        'departure_date',
        'arrival_date',
        'recipient_name',
        'recipient_surname',
        'recipient_phone',
        'order_locations_statuses_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Order::class;
    }
}
