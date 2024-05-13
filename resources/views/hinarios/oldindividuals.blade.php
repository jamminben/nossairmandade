@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.hinarios.individual.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.hinarios.individual.page_title') }}</h2>
@endsection

@section('content')
<div class="col-sm-6 col-md-7 col-lg-7">
    @foreach ($people as $person)
        <div class="name-anchor"><a name="{{ $person->id }}"></a></div>
        <article class="post side-item side-md content-padding with_background rounded overflow_hidden loop-color">
            <div class="row">
                <div class="col-md-5">
                    <div class="item-media"> <img src="{{ url('images/persons/' . $person->getPortrait()) }}" alt="">
                        <div class="media-links"> <a class="abs-link" title="" href="{{ url($person->getSlug()) }}"></a> </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="entry-meta no-avatar ns content-justify">
                        <div class="inline-content big-spacing small-text bigbig darklinks">
                            <span>
                                <a href="{{ url($person->getSlug()) }}">{{ $person->display_name }}</a>
                            </span>
                        </div>
                    </div>
                    @if ($person->getDescription() != '')
                    <div class="item-content border-bottom small-padding">
                        <p>{{ $person->getDescription() }}</p>
                    </div>
                    @endif
                    <div class="item-content">
                        @foreach ($person->hinarios as $hinario)
                        <h4 class="entry-title"> <a href="{{ url($hinario->getSlug()) }}">{{ $hinario->getName($hinario->original_language_id) }}</a> </h4>
                            <p>{{ $hinario->getDescription() }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </article>
        <br>
    @endforeach
</div>
<!--eof .col-sm-8 (main content)-->
<!-- sidebar -->
<aside class="col-sm-4 col-md-4 col-lg-4">
    <div class="row">
        <div class="col-sm-10">
            <h5>{{ __('individuals.right_column.header') }}</h5>
            <ul class="list1 no-bullets">
                @foreach ($people as $person)
                    <li><a href="#{{ $person->id }}">{{ $person->display_name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</aside>
<!-- eof aside sidebar -->
@endsection
