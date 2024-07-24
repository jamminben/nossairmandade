@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.subscribe.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.subscribe.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-xs-6">
        {!! __('subscribe.body') !!}
    </div>
    <div class="col-xs-1"></div>
    <div class="col-xs-5 text-center">
        {!! __('donate.donateButton') !!}
    </div>
@endsection
