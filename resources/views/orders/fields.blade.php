@if($customFields)
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 57px;
        height: 30px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 2px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- User Id Field -->
    @hasanyrole('client')
    <div class="form-group row " hidden>
        {!! Form::label('user_id', trans("lang.order_user_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('user_id', auth()->user()->id , ['class' => 'form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_user_id_help") }}</div>
        </div>
    </div>
    <div class="form-group row " hidden>
        {!! Form::label('name', trans("lang.order_user_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('name', auth()->user()->name , ['class' => 'form-control','id' => 'name']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_user_id_help") }}</div>
        </div>
    </div>
    <div class="form-group row " hidden>
        {!! Form::label('phone', trans("lang.order_user_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('phone', auth()->user()->phone , ['class' => 'form-control','id' => 'phone']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_user_id_help") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('type_product', trans("lang.order_type_product"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('type_product', null,  ['class' => 'form-control', 'placeholder'=>  trans("lang.order_type_product_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_type_product_help") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('masse', trans("lang.order_masse"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('masse', null,  ['class' => 'form-control', 'step'=>"any",'placeholder'=>  trans("lang.order_masse_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_masse_help") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('type_truck', trans("lang.order_type_truck"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('type_truck', $orderTypeofTruck, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_type_truck") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('number_truck', trans("lang.order_number_truck"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('number_truck', null,  ['class' => 'form-control', 'step'=>"any",'placeholder'=>  trans("lang.order_number_truck_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_number_truck") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('departure_address', trans("lang.order_departure_address"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('departure_address', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_departure_address_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_departure_address") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('arrival_address', trans("lang.order_arrival_address"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('arrival_address', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_arrival_address_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_arrival_address") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('departure_date', trans("lang.order_departure_date"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('departure_date', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_departure_date_placeholder"), 'id'=>'datepickerdep']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_departure_date") }}</div>
        </div>
    </div>
    <!-- Payment Status -->
    <div class="form-group row ">
        {!! Form::label('status', trans("lang.payment_status"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('status',isset($order->payment) ? $order->payment->status : '', ['class' => 'form-control', 'readonly'=>'readonly']) !!}
            <div class="form-text text-muted">{{ trans("lang.payment_status_help") }}</div>
        </div>
    </div>
    @endhasanyrole
    @hasanyrole('admin')
    <div class="form-group row ">
        {!! Form::label('type_product', trans("lang.order_type_product"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('type_product', null,  ['class' => 'form-control', 'placeholder'=>  trans("lang.order_type_product_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_type_product_help") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('masse', trans("lang.order_masse"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('masse', null,  ['class' => 'form-control', 'step'=>"any",'placeholder'=>  trans("lang.order_masse_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_masse_help") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('type_truck', trans("lang.order_type_truck"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('type_truck', $orderTypeofTruck, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_type_truck") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('number_truck', trans("lang.order_number_truck"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('number_truck', null,  ['class' => 'form-control', 'step'=>"any",'placeholder'=>  trans("lang.order_number_truck_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_number_truck") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('departure_address', trans("lang.order_departure_address"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('departure_address', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_departure_address_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_departure_address") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('arrival_address', trans("lang.order_arrival_address"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('arrival_address', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_arrival_address_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_arrival_address") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('departure_date', trans("lang.order_departure_date"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('departure_date', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_departure_date_placeholder"), 'id'=>'datepickerdep']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_departure_date") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('arrival_date', trans("lang.order_arrival_date"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('arrival_date', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_arrival_date_placeholder"), 'id'=>'datepickerariv']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_arrival_date") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('recipient_name', trans("lang.order_recipient_name"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('recipient_name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_recipient_name_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_recipient_name") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('recipient_phone', trans("lang.order_recipient_phone"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::tel('recipient_phone', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_recipient_phone_placeholder")]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_recipient_phone") }}</div>
        </div>
    </div>
    @endhasanyrole
    @hasanyrole('manager')
    <div class="form-group row ">
        {!! Form::label('type_product', trans("lang.order_type_product"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('type_product', null,  ['class' => 'form-control', 'placeholder'=>  trans("lang.order_type_product_placeholder"),'readonly']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_type_product_help") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('masse', trans("lang.order_masse"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('masse', null,  ['class' => 'form-control', 'step'=>"any",'placeholder'=>  trans("lang.order_masse_placeholder"),'readonly']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_masse_help") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('type_truck', trans("lang.order_type_truck"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('type_truck',isset($order->type_truck) ? $order->truck->type_truck : '',  ['class' => 'form-control','placeholder'=>  trans("lang.order_type_truck_placeholder"),'readonly']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_type_truck") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('number_truck', trans("lang.order_number_truck"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('number_truck', null,  ['class' => 'form-control', 'step'=>"any",'placeholder'=>  trans("lang.order_number_truck_placeholder"),'readonly']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_number_truck") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('departure_address', trans("lang.order_departure_address"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('departure_address', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_departure_address_placeholder"),'readonly']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_departure_address") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('arrival_address', trans("lang.order_arrival_address"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('arrival_address', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_arrival_address_placeholder"),'readonly']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_arrival_address") }}</div>
        </div>
    </div>
    @endhasanyrole
</div>

<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    @hasanyrole('admin')
    <div class="form-group row ">
        {!! Form::label('user_id', trans("lang.order_user_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('user_id', $user, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_user_id_help") }}</div>
        </div>
    </div>
    <!-- Driver Id Field -->
    <div class="form-group row ">
        {!! Form::label('driver_id', trans("lang.order_driver_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('driver_id', $driver, null, ['data-empty'=>trans("lang.order_driver_id_placeholder"),'class' => 'select2 not-required form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_driver_id_help") }}</div>
        </div>
    </div>
    <!-- Partner apply Field id -->
    <div class="form-group row ">
        {!! Form::label('partners[]', trans("lang.order_partners_applied"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('partners[]',$manager,$ordersSelected,['class' => 'select2 form-control' , 'multiple'=>'multiple']) !!}
        </div>
    </div>
    <!-- Order Status Id Field -->
    <div class="form-group row ">
        {!! Form::label('order_status_id', trans("lang.order_order_status_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('order_status_id', $orderStatus, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_order_status_id_help") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('order_locations_status_id', trans("lang.order_locations_status_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('order_locations_statuses_id', $orderLocationsStatus, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_locations_status_id_help") }}</div>
        </div>
    </div>
    <!-- Status Field -->
    @if(!empty($order->payment_id))
    <div class="form-group row ">
        {!! Form::label('status', trans("lang.payment_status"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('status',
            [
                'Not Paid' => trans('lang.order_not_paid'),
            'Partialy Paid' => trans('lang.order_pending'),
            'Paid' => trans('lang.order_paid'),
            ]
            , isset($order->payment) ? $order->payment->status : '', ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.payment_status_help") }}</div>
        </div>
    </div>
    @endif
    <!-- 'Boolean active Field' -->
    <div class="form-group row ">
        {!! Form::label('active', trans("lang.order_active"),['class' => 'col-3 control-label text-right']) !!}
        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                {!! Form::hidden('active', 0) !!}
                {!! Form::checkbox('active', 1, null) !!}
            </label>
        </div>
    </div>
    <!-- Tax Field -->
    <div class="form-group row ">
        {!! Form::label('tax', trans("lang.order_tax"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('tax', null,  ['class' => 'form-control', 'step'=>"any",'placeholder'=>  trans("lang.order_tax_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.order_tax_help") }}
            </div>
        </div>
    </div>
    <!-- delivery_fee Field -->
    <div class="form-group row ">
        {!! Form::label('delivery_fee', trans("lang.order_delivery_fee"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('delivery_fee', null,  ['class' => 'form-control','step'=>"any",'placeholder'=>  trans("lang.order_delivery_fee_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.order_delivery_fee_help") }}
            </div>
        </div>
    </div>
    <!-- Payment Id Field -->
    <div class="form-group row ">
        {!! Form::label('payment_id', trans("lang.order_payment_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('payment_id',$notpaid,null, ['data-empty'=>trans("lang.order_payment_id_placeholder"),'class' => 'select2 not-required form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_payment_id_help") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('hint', trans("lang.order_hint"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::textarea('hint', null, ['class' => 'form-control','placeholder'=>
             trans("lang.order_hint_placeholder")  ]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_hint_help") }}</div>
        </div>
    </div>
    @endhasanyrole
    @hasanyrole('manager')
    <div class="form-group row ">
        {!! Form::label('departure_date', trans("lang.order_departure_date"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('departure_date', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_departure_date_placeholder"), 'id'=>'datepickerdep','readonly']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_departure_date") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('arrival_date', trans("lang.order_arrival_date"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('arrival_date', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_arrival_date_placeholder"), 'id'=>'datepickerariv','readonly']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_arrival_date") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('recipient_name', trans("lang.order_recipient_name"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('recipient_name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_recipient_name_placeholder"),'readonly']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_recipient_name") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('order_locations_status_id', trans("lang.order_locations_status_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('order_locations_statuses_id', $orderLocationsStatus, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_locations_status_id_help") }}</div>
        </div>
    </div>
    <!-- Status Field -->
    @if(!empty($order->payment_id))
        <div class="form-group row ">
            {!! Form::label('status', trans("lang.payment_status"),['class' => 'col-3 control-label text-right']) !!}
            <div class="col-9">
                {!! Form::text('status',
                $order->payment ? $order->payment->status : '', ['class' => 'form-control', 'readonly']) !!}
                <div class="form-text text-muted">{{ trans("lang.payment_status_help") }}</div>
            </div>
        </div>
    @endif
    <div class="form-group row" hidden>
        {!! Form::label('apply', trans("lang.order_apply"),['class' => 'col-3 control-label text-center']) !!}
        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                {!! Form::hidden('apply', 0) !!}
                {!! Form::checkbox('apply', 1, true) !!}
            </label>
        </div>
    </div>
    @endhasanyrole
    @hasanyrole('client')
    <div class="form-group row ">
        {!! Form::label('arrival_date', trans("lang.order_arrival_date"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('arrival_date', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_arrival_date_placeholder"), 'id'=>'datepickerariv']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_arrival_date") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('option', trans("lang.order_option"),['class' => 'col-3 control-label text-right']) !!}
        <label class="switch">
                <input type="checkbox" onclick="SetBilling(this.checked);">
                <span class="slider round"></span>
        </label>
    </div>
    <div class="form-group row ">
        {!! Form::label('recipient_name', trans("lang.order_recipient_name"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('recipient_name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_recipient_name_placeholder"),'id'=>'recipient_name']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_recipient_name") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('recipient_phone', trans("lang.order_recipient_phone"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::tel('recipient_phone', null,  ['class' => 'form-control','placeholder'=>  trans("lang.order_recipient_phone_placeholder"),'id'=>'recipient_phone']) !!}
            <div class="form-text text-muted">{{ trans("lang.order_recipient_phone") }}</div>
        </div>
    </div>
    <div class="form-group row ">
        {!! Form::label('hint', trans("lang.order_hint"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::textarea('hint', null, ['class' => 'form-control','placeholder'=>
             trans("lang.order_hint_placeholder")  ]) !!}
            <div class="form-text text-muted">{{ trans("lang.order_hint_help") }}</div>
        </div>
    </div>
    @endhasanyrole
</div>
@if($customFields)
    <div class="clearfix"></div>
    <div class="col-12 custom-field-container">
        <h5 class="col-12 pb-4">{!! trans('lang.custom_field_plural') !!}</h5>
        {!! $customFields !!}
    </div>
@endif
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    @hasanyrole('manager')
    @if($count==1)
        <button type="button" class="btn btn-success"><i class="fa fa-check"></i> {{trans('lang.order_apply_success')}}</button>
    @else
        <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> {{trans('lang.order_apply')}}</button>
    @endif
    @endhasanyrole
    @hasanyrole('admin|client')
    <button type="submit" class="btn btn-{{setting('theme_color')}}"><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.order')}}</button>
    @endhasanyrole
    <a href="{!! route('orders.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(function() {
        $('#datepickerdep').datepicker();
        $('#datepickerariv').datepicker();
    });
    function SetBilling(checked) {
        if (checked) {
            document.getElementById('recipient_name').value = document.getElementById('name').value;
            document.getElementById('recipient_phone').value = document.getElementById('phone').value;

        } else {
            document.getElementById('recipient_name').value = '';
            document.getElementById('recipient_phone').value = '';
        }
    }
</script>
