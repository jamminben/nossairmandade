@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.other.musicians.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.other.musicians.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-sm-10">
        <h5>
            {!! __('musicians.pageDescription') !!}
        </h5>

        <ul class="list1 no-bullets">
            @foreach ($files as $file)
                <li>
                    <a href="{{ $file->mediaFile->url }}">{{ $file->mediaFile->filename }}</a><br>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
