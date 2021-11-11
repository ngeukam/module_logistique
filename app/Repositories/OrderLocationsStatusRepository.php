<?php

namespace App\Repositories;


use App\Models\OrderLocationsStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OrderLocationsStatusRepository.
 *
 * @package namespace App\Repositories;
 * @method OrderLocationsStatus findWithoutFail($id, $columns = ['*'])
 * @method OrderLocationsStatus find($id, $columns = ['*'])
 * @method OrderLocationsStatus first($columns = ['*'])
 */
class OrderLocationsStatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'locations_status'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderLocationsStatus::class;
    }

    
}
