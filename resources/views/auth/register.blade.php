@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.auth.register.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">
        {{ __('pagetitles.auth.register.page_title') }}
    </h2>
@endsection

@section('content')
<div class="col-sm-8 col-sm-offset-4 text-center" data-animation="scaleAppear">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group bottommargin_0">
                    <label for="name">
                        {{ __('auth.register.form.name') }}
                        <span class="required">*</span>
                    </label>
                    <input type="text" aria-required="true" size="30" value="{{ old('name') }}" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('auth.register.form.name') }}*">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group bottommargin_0">
                    <label for="email">
                        {{ __('auth.register.form.email') }}
                        <span class="required">*</span>
                    </label>
                    <input type="text" aria-required="true" size="30" value="{{ old('email') }}" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('auth.register.form.email') }}*">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group bottommargin_0">
                    <label for="password">
                        {{ __('auth.register.form.password') }}
                        <span class="required">*</span>
                    </label>
                    <input type="password" aria-required="true" size="30" value="{{ old('password') }}" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('auth.register.form.password') }}*">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group bottommargin_0">
                    <label for="password-confirm">
                        {{ __('auth.register.form.password-confirm') }}
                        <span class="required">*</span>
                    </label>
                    <input type="password" aria-required="true" size="30" value="{{ old('password_confirmation') }}" name="password_confirmation" id="password-confirm" class="form-control" placeholder="{{ __('auth.register.form.password') }}*">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="contact-form-submit topmargin_10">
                    <button type="submit" id="register_form_submit" name="register_submit" class="theme_button color4 min_width_button margin_0">{{ __('auth.register.form.submit') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
