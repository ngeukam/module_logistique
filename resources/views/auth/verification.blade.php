@extends('layouts.auth.default')
@section('content')
    <div class="card-body login-card-body">
        @if (session('errorcodeverif'))
            <div class="alert alert-danger" role="alert">
                {{session('errorcodeverif')}}
            </div>
        @endif
        {{__('auth.message_OTP')}}: {{Session::get('phonenumberSession')}}
        <form action="{{ url('/code-verification') }}" method="post">
            {!! csrf_field() !!}
                <input type="" name="verification_code" value="{{Session::get('verificationcodeSession')}}" >
                <input type="hidden" name="phone" value="{{Session::get('phonenumberSession')}}" >
            <div class="input-group mb-3">
                <input  type="text" class="form-control {{ $errors->has('check_code') ? ' is-invalid' : '' }}" name="check_code" placeholder="{{__('auth.check_code')}}" aria-label="{{__('auth.check_code')}}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                </div>
                @if ($errors->has('check_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('check_code') }}
                    </div>
                @endif
            </div>

            <div class="row mb-2">
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">{{__('auth.submit_code')}}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-card-body -->
@endsection