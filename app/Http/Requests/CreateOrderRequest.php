<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Order;

class CreateOrderRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (auth()->user()->hasRole('admin')) {
            return Order::$adminRules;
        } elseif (auth()->user()->hasRole('client')) {
            return Order::$clientRules;
        }
        elseif (auth()->user()->hasRole('manager')) {
            return Order::$managerRules;
        }
    }
}
