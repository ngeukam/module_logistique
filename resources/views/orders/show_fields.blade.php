<!-- Id Field -->
<div class="form-group row col-md-4 col-sm-12">
    {!! Form::label('id', trans('lang.order_id'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
    <p>#{!! $order->id !!}</p>
  </div>

    {!! Form::label('order_client', trans('lang.order_client'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
    <p>{!! $order->user->name !!}</p>
  </div>

    {!! Form::label('order_client_phone', trans('lang.order_client_phone'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
    <p>{!! $order->user->phone !!}</p>
  </div>
    {!! Form::label('departure_address', trans('lang.order_departure_address'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
    <p>{!! $order->departure_address !!}</p>
  </div>
    {!! Form::label('departure_date', trans('lang.order_departure_date'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
        <p>{!! $order->departure_date !!}</p>
    </div>
    {!! Form::label('arrival_address', trans('lang.order_arrival_address'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
        <p>{!! $order->arrival_address !!}</p>
    </div>
    {!! Form::label('arrival_date', trans('lang.order_arrival_date'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
        <p>{!! $order->arrival_date !!}</p>
    </div>

    {!! Form::label('order_date', trans('lang.order_date'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
    <p>{!! $order->created_at !!}</p>
  </div>


</div>

<!-- Order Status Id Field -->
<div class="form-group row col-md-4 col-sm-12">
    {!! Form::label('type_product', trans('lang.order_type_product'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
        <p>{!! $order->type_product  !!}</p>
    </div>

    {!! Form::label('order_status_id', trans('lang.order_status_status'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
    <p>{!! $order->orderStatus->status  !!}</p>
  </div>

    {!! Form::label('active', trans('lang.order_active'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
    @if($order->active)
      <p><span class='badge badge-success'> {{trans('lang.yes')}}</span></p>
      @else
      <p><span class='badge badge-danger'>{{trans('lang.order_canceled')}}</span></p>
      @endif
  </div>

    {!! Form::label('payment_method', trans('lang.payment_method'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
    <p>{!! isset($order->payment) ? $order->payment->method : ''  !!}</p>
  </div>

    {!! Form::label('payment_status', trans('lang.payment_status'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
    <p>{!! isset($order->payment) ? $order->payment->status : trans('lang.order_not_paid')  !!}</p>
  </div>
    {!! Form::label('order_updated_date', trans('lang.order_updated_at'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
        <p>{!! $order->updated_at !!}</p>
    </div>

</div>

<!-- Id Field -->
<div class="form-group row col-md-4 col-sm-12">
    {!! Form::label('type_truck', trans('lang.order_type_truck'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
        <p>{!! isset($order->type_truck) ? $order->truck->type_truck : ''  !!}</p>
    </div>

    {!! Form::label('number_truck', trans('lang.order_number_truck'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
        <p>{!! $order->number_truck !!}</p>
    </div>

    {!! Form::label('recipient_name', trans('lang.order_recipient_name'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
            <p>{!! $order->recipient_name !!}</p>
    </div>

    {!! Form::label('recipient_phone', trans('lang.order_recipient_phone'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
            <p>{!! $order->recipient_phone !!}</p>
    </div>

    {!! Form::label('partners', trans('lang.order_partners_applied'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
        @if(!empty($ordersSelected))
            {!! Form::select('partners[]',$manager,$ordersSelected,['class' => 'select2 form-control' , 'multiple'=>'multiple']) !!}
        @else
            <p>{{trans('lang.order_driver_not_assigned')}}</p>
        @endif

    </div>

    {!! Form::label('hint', 'More details:', ['class' => 'col-4 control-label']) !!}
    <div class="col-8">
        <p>{!! $order->hint !!}</p>
    </div>

</div>

{{--<!-- Tax Field -->--}}
{{--<div class="form-group row col-md-6 col-sm-12">--}}
{{--  {!! Form::label('tax', 'Tax:', ['class' => 'col-4 control-label']) !!}--}}
{{--  <div class="col-8">--}}
{{--    <p>{!! $order->tax !!}</p>--}}
{{--  </div>--}}
{{--</div>--}}


