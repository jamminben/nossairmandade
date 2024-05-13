@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.hinarios.local.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.hinarios.local.page_title') }}</h2>
@endsection

@section('extra_styles')
    <link rel="stylesheet" href="/css/hymns.css">
    <link rel="stylesheet" href="/css/hinarios.css">
@endsection

@section('content')
    <div class="col-sm-10 col-md-10 col-lg-10 local-hinario">
        <ul class="list1 no-bullets no-top-border no-bottom-border">
            @foreach (array_keys($hinarios) as $country)
                <li>
                    <div class="local-hinario-country">{{ $country }}</div>
                @foreach (array_keys($hinarios[$country]) as $state)
                    <div class="local-hinario-state">{{ $state }}</div>
                    @foreach (array_keys($hinarios[$country][$state]) as $city)
                        <div class="local-hinario-city">{{ $city }}</div>
                        @foreach (array_keys($hinarios[$country][$state][$city]) as $church)
                                <div class="local-hinario-church">{{ $church }}</div>
                                @foreach (array_values($hinarios[$country][$state][$city][$church]) as $hinario)
                                    @include('hinarios.partials.hinario_listing', [ 'hinario' => $hinario ])
                                @endforeach
                        @endforeach
                            <hr>
                    @endforeach
                @endforeach
                </li>
            @endforeach
        </ul>
    </div>
@endsection
