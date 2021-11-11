<?php

namespace App\Repositories;

use App\Models\Truck;
use InfyOm\Generator\Common\BaseRepository;

/**
 * class TruckRepository.
 *
 * @package namespace App\Repositories;
 * @method Truck findWithoutFail($id, $columns = ['*'])
 * @method Truck find($id, $columns = ['*'])
 * @method Truck first($columns = ['*'])
 */
class TruckRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type_truck'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Truck::class;
    }
}
