@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.contact.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.contact.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-sm-6" data-animation="scaleAppear">
        <h3>{{ __('contact.title') }}</h3>
        @if (\Illuminate\Support\Facades\Session::has('success'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">{{ __('universal.close') }}</span>
                </button>
                <strong>{{ \Illuminate\Support\Facades\Session::get('success') }}</strong>
            </div><br>
        @endif
        <form class="contact_form row columns_padding_10" method="post" action="{{ url('/contact') }}">
            @csrf
            <div class="col-sm-6">
                <div class="form-group bottommargin_0">
                    <label for="name">
                        {{ __('contact.formElements.fullName') }}
                        <span class="required">*</span>
                    </label>
                    <input type="text" aria-required="true" size="30" value="" name="name" id="name" class="form-control" placeholder="{{ __('contact.formElements.fullName') }}*">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group bottommargin_0">
                    <label for="email">
                        {{ __('contact.formElements.email') }}
                        <span class="required">*</span>
                    </label>
                    <input type="email" aria-required="true" size="30" value="" name="email" id="email" class="form-control" placeholder="{{ __('contact.formElements.email') }}*">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group bottommargin_0">
                    <label for="subject">
                        {{ __('contact.formElements.subject') }}
                        <span class="required">*</span>
                    </label>
                    <input type="text" aria-required="true" size="30" value="" name="subject" id="subject" class="form-control" placeholder="{{ __('contact.formElements.subject') }}*">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group bottommargin_0">
                    <label for="message">
                        {{ __('contact.formElements.text') }}
                        <span class="required">*</span>
                    </label>
                    <textarea aria-required="true" rows="5" cols="45" name="message" id="message" class="form-control" placeholder="{{ __('contact.formElements.text') }}*"></textarea>
                </div>
            </div>
            <div class="col-sm-12 center">
                <div class="row">
                    <div class="text-center">
                        <div class="g-recaptcha" data-sitekey="{{ config('recaptcha.api_site_key') }}" style="display: inline-block;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="contact-form-submit topmargin_10 text-center">
                        <button type="submit" id="contact_submit" name="contact_submit" class="theme_button color4 min_width_button margin_0">{{ __('contact.formElements.submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--.col-* -->
    <div class="col-sm-4" data-animation="scaleAppear">
        <section class="cs" style="padding: 5px;">
        <h3>{{ __('contact.disclaimer.header') }}</h3>
        <p>
            {!! __('contact.disclaimer.text') !!}
        </p>
        </section>
    </div>
@endsection
