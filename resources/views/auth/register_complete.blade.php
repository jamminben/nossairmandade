@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.auth.register_complete.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">
        {{ __('pagetitles.auth.register_complete.page_title') }}
    </h2>
@endsection

@section('content')
    <div class="col-sm-8">
        <h5>An email is on its way with your confirmation link in it.</h5>
    </div>
@endsection
