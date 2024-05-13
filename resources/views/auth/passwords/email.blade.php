@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.auth.email.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">
        {{ __('pagetitles.auth.email.page_title') }}
    </h2>
@endsection

@section('content')
    <div class="col-sm-8 col-sm-offset-4 text-center" data-animation="scaleAppear">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group bottommargin_0">
                        <label for="email">
                            {{ __('auth.email.form.email') }}
                        </label>
                        <input type="text" aria-required="true" size="30" value="{{ old('email') }}" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('auth.email.form.email') }}">

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
                    <div class="contact-form-submit topmargin_10">
                        <button type="submit" id="register_form_submit" name="email_submit" class="theme_button color4 min_width_button margin_0">{{ __('auth.email.form.submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
