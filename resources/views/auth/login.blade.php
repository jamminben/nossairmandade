@extends('auth.myapp')

@section('header_title')
    {{ __('pagetitles.auth.login.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">
        {{ __('pagetitles.auth.login.page_title') }}
    </h2>
@endsection

@section('content')
    <div class="col-sm-9 col-sm-offset-3 text-center" data-animation="scaleAppear">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="row">
            <div class="col-sm-3 text-right vertical-center columns_margin_top_10">
                <label for="email">
                    {{ __('auth.login.form.email') }}
                    <span class="required">*</span>
                </label>
            </div>
            <div class="col-sm-4 text-left">
                <input type="text" aria-required="true" size="30" value="{{ old('email') }}" name="email" id="email" class="@error('email') is-invalid @enderror" placeholder="{{ __('auth.login.form.email') }}">

                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3 text-right vertical-center columns_margin_top_10">
                <label for="password">
                    {{ __('auth.login.form.password') }}
                    <span class="required">*</span>
                </label>
            </div>
            <div class="col-sm-4 text-left">
                    <input type="password" aria-required="true" size="30" value="{{ old('password') }}" name="password" id="password" class="@error('password') is-invalid @enderror" placeholder="{{ __('auth.login.form.password') }}">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 text-center">
                <input type="checkbox" value="{{ old('remember') ? 'checked' : '' }}" name="remember" id="remember">
                <label for="remember" style="padding-left: 20px;">
                    {{ __('auth.login.form.remember') }}
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="contact-form-submit topmargin_10">
                    <button type="submit" id="contact_form_submit" name="contact_submit" class="theme_button color4 min_width_button margin_0">{{ __('auth.login.form.submit') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
