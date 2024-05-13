@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.other.friends.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.other.friends.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-sm-10">
        @foreach ($sections as $section)
            <h4>
                {{ $section->getName() }}
            </h4>

            <ul class="list2">
            @foreach ($section->links as $link)
                <li>
                    <a href="{{ $link->url }}">{{ $link->getName() }}</a><br>
                    {{ $link->getDescription() }}
                </li>
            @endforeach
            </ul>
        @endforeach
    </div>
@endsection
