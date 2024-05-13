@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.hinarios.individual.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('pagetitles.hinarios.individual.page_title') }}</h2>
@endsection

@section('content')


    <div class="col-sm-6 col-md-7 col-lg-7">
        <div class="mobile-active"><a href="#toc" style="padding-bottom: 20px;">{{ __('hinarios.individuals.jump') }}</a></div>
        <ul class="list1 no-bullets no-top-border no-bottom-border">
            @foreach ($people as $person)
            <div class="name-anchor"><a name="{{ $person->id }}"></a></div>
            
            <li>
                <div class="row">
                    <div class="col-md-5">
                        <div class="item-media"> <img src="{{ url($person->getPortrait()) }}" alt="">
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

                        <div class="item-content small-padding padding-top-20 nossa-indent">
                            @if (count($person->hinarios) > 1)
                                <p>Hinários:</p>
                            @elseif (count($person->hinarios) == 1)
                                <p>Hinário:</p>
                            @endif
                            <ul class="list1 no-top-border no-bottom-border">
                                @foreach ($person->hinarios as $hinario)
                                    <li>
                                        <h4 class="entry-title">

                                                <a href="{{ url($hinario->getSlug()) }}">
                                                    <span class="nossa-blue">
                                                        {{ $hinario->getName($hinario->original_language_id) }}
                                                    </span>
                                                </a>
                                        </h4>
                                        <p>{{ $hinario->getDescription() }}</p>
                                    </li>
                            @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </li>
            <br>
        @endforeach
        </ul>
    </div>

    <!--eof .col-sm-8 (main content)-->

    <!-- sidebar -->
    <div class="col-sm-4 col-md-4 col-lg-4" style="float: left">
        <div class="row">
            <div class="col-sm-10">
                <a name="toc" class="name-anchor-mobile"></a>
                <h5>{{ __('hinarios.individuals.right_column.header') }}</h5>
                <ul class="list1 no-bullets">
                    @foreach ($tableOfContents as $person)
                        <li><a href="#{{ $person->id }}">{{ $person->display_name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- eof aside sidebar -->

@endsection
