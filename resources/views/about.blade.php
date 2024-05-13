@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.about.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.about.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-xs-6">
        {!! __('about.body') !!}
    </div>
    <div class="col-xs-4 text-left">
        <div class="widget widget_banner">
            <div class="vertical-item content-absolute ds rounded overflow_hidden">
                <div class="item-media"> <img src="{{ url('images/ben.jpg') }}" alt="Ben">
                </div>
            </div>
        </div>
    </div>
@endsection
