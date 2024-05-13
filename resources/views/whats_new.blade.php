@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.whats_new.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.whats_new.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-sm-10 col-lg-10">
        {!! __('whats_new.body') !!}
    </div>
@endsection
