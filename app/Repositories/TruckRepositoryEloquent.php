<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TruckRepository;
use App\Entities\Truck;
use App\Validators\TruckValidator;

/**
 * Class TruckRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TruckRepositoryEloquent extends BaseRepository implements TruckRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Truck::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
