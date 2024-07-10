@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.tos.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.tos.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-xs-6">
        {!! __('tos.body') !!}
    </div>
    <div class="col-xs-1"></div>
    <div class="col-xs-5 text-center">
        {!! __('donate.donateButton') !!}
    </div>
@endsection
