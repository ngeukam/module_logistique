<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;

/**
 * Class Truck
 * @package App\Models
 * @version August 29, 2019, 9:38 pm UTC
 * @property \App\Models\Truck truck
 * @property string type_truck
 */

class Truck extends Model
{
    public $table = 'trucks';



    public $fillable = [
        'type_truck'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type_truck' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type_truck' => 'required'
    ];
}
