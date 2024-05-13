@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.hinarios.compilations.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.hinarios.compilations.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-sm-10 col-md-10 col-lg-10">
        <ul class="list1 no-bullets no-top-border">
            @foreach ($hinarios as $hinario)
                <li>
                    @include('hinarios.partials.hinario_listing', [ 'hinario' => $hinario ])
                </li>
            @endforeach
        </ul>
    </div>
@endsection
