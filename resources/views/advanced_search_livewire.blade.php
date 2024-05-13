@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.search.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.search.page_title') }}</h2>
@endsection

@section('content')

    <livewire:search />

@endsection
