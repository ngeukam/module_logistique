<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TruckRepositoryRepository;
use App\Entities\TruckRepository;
use App\Validators\TruckRepositoryValidator;

/**
 * Class TruckRepositoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TruckRepositoryRepositoryEloquent extends BaseRepository implements TruckRepositoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TruckRepository::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
