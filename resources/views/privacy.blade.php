@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.privacy.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.privacy.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-xs-6">
        {!! __('privacy.body') !!}
    </div>
    <div class="col-xs-1"></div>
    <div class="col-xs-5 text-center">
        {!! __('donate.donateButton') !!}
    </div>
@endsection
