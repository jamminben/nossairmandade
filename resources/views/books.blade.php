@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.other.books.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.other.books.page_title') }}</h2>
@endsection

@section('content')
    <div class="col-sm-10">
        @foreach ($books as $book)
            @if ($loop->index % 2 == 0)
                <article class="post side-item side-md content-padding with_background rounded overflow_hidden loop-color">
                    <div class="row">
                        @include ('layouts.partials.book_description', [ 'book' => $book ])
                        @include ('layouts.partials.book_image', [ 'book' => $book ])
                    </div>
                </article>
            @else
                <article class="post side-item side-md content-padding with_background rounded overflow_hidden loop-color">
                    <div class="row">
                        @include ('layouts.partials.book_image', [ 'book' => $book ])
                        @include ('layouts.partials.book_description', [ 'book' => $book ])
                    </div>
                </article>
            @endif
        @endforeach

    </div>
@endsection
