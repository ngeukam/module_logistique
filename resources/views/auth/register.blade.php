@extends('layouts.auth.default')
@section('content')
    <?php

    function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(Uuid::generate(4)->string,True)), 16, 36), 0, $limit);
    }
    ?>
    <div class="card-body login-card-body">
        <p class="login-box-msg">{{__('auth.register_new_member')}}</p>

        <form action="{{ url('/register') }}" method="post">
            {!! csrf_field() !!}
            <div class="input-group mb-3">
            <select name="role" id="role"  class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}">
                <option value="">--{{__('auth.select_role')}}--</option>
                <option value="3">{{__('auth.partner')}}</option>
                <option value="4">{{__('auth.customer')}}</option>
            </select>
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>
                @if ($errors->has('role'))
                    <div class="invalid-feedback">
                        {{ $errors->first('role') }}
                    </div>
                @endif
            </div>
            <input type="hidden" name="verification_code" value="<?php echo strtoupper(unique_code(4)) ?>" >
            <div class="input-group mb-3">
                <input value="{{ old('name') }}" type="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="{{__('auth.name')}}" aria-label="{{__('auth.name')}}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>
                @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="input-group mb-3">
                <input value="{{ old('email') }}" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="{{__('auth.email')}}" aria-label="{{__('auth.email')}}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                </div>
                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <div class="input-group mb-3">
                <select name="country">
                    <option value="CM" selected="selected" cunt_code="+237" >Cameroun +237</option>
                    <option value="CI" selected="selected" cunt_code="+225" >Ivory Coast +225</option>
                </select>
                <input value="{{ old('phone') }}" type="tel" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" placeholder="{{__('auth.phone')}}" aria-label="{{__('auth.phone')}}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                </div>
            @if ($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
            </div>

            <div class="input-group mb-3">
                <input value="{{ old('password') }}" type="password" class="form-control  {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{__('auth.password')}}" aria-label="{{__('auth.password')}}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                </div>
                @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <div class="input-group mb-3">
                <input value="{{ old('password_confirmation') }}" type="password" class="form-control  {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="{{__('auth.password_confirmation')}}" aria-label="{{__('auth.password_confirmation')}}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                </div>
                @if ($errors->has('password_confirmation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                @endif
            </div>

            <div class="row mb-2">
                <div class="col-8">
                    <div class="checkbox icheck">
                        <label> <input type="checkbox" name="remember"> {{__('auth.agree')}}</label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">{{__('auth.register')}}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        @if(setting('enable_facebook',false) || setting('enable_google',false) || setting('enable_twitter',false))
            <div class="social-auth-links text-center mb-3">
                <p style="text-transform: uppercase">- {{__('lang.or')}} -</p>
                @if(setting('enable_facebook',false))
                    <a href="{{url('login/facebook')}}" class="btn btn-block btn-facebook"> <i class="fa fa-facebook mr-2"></i> {{__('auth.login_facebook')}}
                    </a>
                @endif
                @if(setting('enable_google',false))
                    <a href="{{url('login/google')}}" class="btn btn-block btn-google"> <i class="fa fa-google-plus mr-2"></i> {{__('auth.login_google')}}
                    </a>
                @endif
                @if(setting('enable_twitter',false))
                    <a href="{{url('login/twitter')}}" class="btn btn-block btn-twitter"> <i class="fa fa-twitter mr-2"></i> {{__('auth.login_twitter')}}
                    </a>
                @endif
            </div>
            <!-- /.social-auth-links -->
        @endif

        <p class="mb-1 text-center">
            <a href="{{ url('/login') }}">{{__('auth.already_member')}}</a>
        </p>
    </div>
    <!-- /.login-card-body -->
@endsection