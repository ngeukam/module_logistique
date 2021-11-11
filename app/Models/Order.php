<?php
/**
 * File name: Order.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;

/**
 * Class Order
 * @package App\Models
 * @version August 31, 2019, 11:11 am UTC
 *
 * @property \App\Models\User user
 * @property \App\Models\DeliveryAddress deliveryAddress
 * @property \App\Models\Payment payment
 * @property \App\Models\OrderStatus orderStatus
 * @property \App\Models\ProductOrder[] productOrders
 * @property integer user_id
 * @property integer order_status_id
 * @property integer payment_id
 * @property double tax
 * @property double delivery_fee
 * @property string id
 * @property int delivery_address_id
 * @property string hint
 */
class Order extends Model
{

    public $table = 'orders';

    public $fillable = [
        'user_id',
        'order_status_id',
        'tax',
        'hint',
        'payment_id',
        'delivery_address_id',
        'delivery_fee',
        'active',
        'driver_id',
        'apply',
        'apply_partner',
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'order_status_id' => 'integer',
        'tax' => 'double',
        'hint' => 'string',
        'status' => 'string',
        'payment_id' => 'integer',
        'delivery_address_id' => 'integer',
        'delivery_fee'=>'double',
        'active'=>'boolean',
        'driver_id' => 'integer',
        'type_product'=> 'string',
        'masse'=> 'double',
        'departure_address'=> 'string',
        'arrival_address'=> 'string',
        'number_truck'=> 'integer',
        'type_truck'=> 'string',
        'departure_date'=> 'date',
        'arrival_date'=> 'date',
        'recipient_name'=> 'string',
        'recipient_surname'=> 'string',
        'recipient_phone'=> 'string',
        'order_locations_statuses_id'=> 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $adminRules = [
        'user_id' => 'nullable|exists:users,id',
        'order_status_id' => 'nullable|exists:order_statuses,id',
        'order_locations_statuses_id'=> 'nullable|exists:order_locations_statuses,id',
        'payment_id' => 'nullable|exists:payments,id',
        'driver_id' => 'nullable|exists:users,id',
        'type_product'=> 'required|string',
        'masse'=> 'required',
        'departure_address'=> 'required|string',
        'arrival_address'=> 'required|string',
        'number_truck'=> 'required|integer',
        'type_truck'=> 'required|string',
        'departure_date'=> 'required|date',
        'arrival_date'=> 'required|date',
    ];

    public static $clientRules = [
        'user_id' => 'nullable|exists:users,id',
        'order_status_id' => 'nullable|exists:order_statuses,id',
        'order_locations_statuses_id'=> 'nullable|exists:order_locations_statuses,id',
        'payment_id' => 'nullable|exists:payments,id',
        'driver_id' => 'nullable|exists:users,id',
        'type_product'=> 'required|string',
        'masse'=> 'required',
        'departure_address'=> 'required|string',
        'arrival_address'=> 'required|string',
        'number_truck'=> 'required|integer',
        'type_truck'=> 'required|string',
        'departure_date'=> 'required|date',
        'arrival_date'=> 'required|date',
    ];
    public static $managerRules = [
        'user_id' => 'nullable|exists:users,id',
        'order_status_id' => 'nullable|exists:order_statuses,id',
        'order_locations_statuses_id'=> 'nullable|exists:order_locations_statuses,id',
        'payment_id' => 'nullable|exists:payments,id',
        'driver_id' => 'nullable|exists:users,id',
        'type_product'=> 'required|string',
        'masse'=> 'required',
        'departure_address'=> 'required|string',
        'arrival_address'=> 'required|string',
        'number_truck'=> 'required|integer',
        'type_truck'=> 'required|string',
        'departure_date'=> 'required|date',
        'arrival_date'=> 'required|date',
    ];

    /**
     * New Attributes
     *
     * @var array
     */
    protected $appends = [
        'custom_fields',
        
    ];

    public function customFieldsValues()
    {
        return $this->morphMany('App\Models\CustomFieldValue', 'customizable');
    }

    public function getCustomFieldsAttribute()
    {
        $hasCustomField = in_array(static::class,setting('custom_field_models',[]));
        if (!$hasCustomField){
            return [];
        }
        $array = $this->customFieldsValues()
            ->join('custom_fields','custom_fields.id','=','custom_field_values.custom_field_id')
            ->where('custom_fields.in_table','=',true)
            ->get()->toArray();

        return convertToAssoc($array,'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function truck()
    {
        return $this->belongsTo(\App\Models\Truck::class, 'type_truck', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function partnerapply()
    {
            return $this->belongsToMany(\App\Models\User::class, 'partner_apply_orders');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function driver()
    {
        return $this->belongsTo(\App\Models\User::class, 'driver_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function orderStatus()
    {
        return $this->belongsTo(\App\Models\OrderStatus::class, 'order_status_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function orderLocationsStatus()
    {
        return $this->belongsTo(\App\Models\OrderLocationsStatus::class, 'order_locations_statuses_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function productOrders()
    {
        return $this->hasMany(\App\Models\ProductOrder::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class, 'product_orders');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function payment()
    {
        return $this->belongsTo(\App\Models\Payment::class, 'payment_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function deliveryAddress()
    {
        return $this->belongsTo(\App\Models\DeliveryAddress::class, 'delivery_address_id', 'id');
    }

    public function setArrivalDateAttribute($value){
        $this->attributes['arrival_date']=Carbon::createFromFormat('m/d/Y',$value)->format('Y-d-m');
    }

    public function getArrivalDateAttribute(){
        return Carbon::createFromFormat('Y-d-m', $this->attributes['arrival_date'])->format('m/d/Y');

    }

    public function setDepartureDateAttribute($value){
        $this->attributes['departure_date']=Carbon::createFromFormat('m/d/Y',$value)->format('Y-d-m');
    }

    public function getDepartureDateAttribute(){
        return Carbon::createFromFormat('Y-d-m', $this->attributes['departure_date'])->format('m/d/Y');

    }
    
}
