<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 * Class Country
 * @package App\Models
 * @version August 29, 2019, 9:38 pm UTC
 *
 * @property string country_name
 */

class Country extends Model
{
    public $table = 'countries';



    public $fillable = [
        'country_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'country_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'country_name' => 'required'
    ];
    /**
     * @return BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'country', 'id');
    }
}
