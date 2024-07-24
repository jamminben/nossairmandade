@extends('layouts.app')

@section('header_title')
    {{ __('pagetitles.hinarios.iceflu.header_title') }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ __('hinarios.iceflu.page_title') }}</h2>
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
                <li>
                    <div class="row">

                        <div class="col-md-5"></div>
                        <div class="col-md-7">
                            <div class="entry-meta no-avatar ns content-justify">
                                <div class="inline-content big-spacing small-text bigbig darklinks">
                            <span>
                                <a>{{ __('hinarios.individuals.right_column.compilations') }}</a>
                            </span>
                                </div>
                            </div>

                            <div class="item-content small-padding padding-top-20 nossa-indent">
                                <ul class="list1 no-top-border no-bottom-border">
                                    <li>
                                        <h4 class="entry-title">

                                            <a name="compilations-oracao" href="{{ url('hinario/1/Oração') }}">
                                                <span class="nossa-blue">
                                                    Oração
                                                </span>
                                            </a>
                                        </h4>
                                    </li>
                                    <li>
                                        <h4 class="entry-title">
                                            <a name="compilations-concentracao" href="{{ url('hinario/5/Concentração') }}">
                                                <span class="nossa-blue">
                                                    Concentração
                                                </span>
                                            </a>
                                        </h4>
                                    </li>
                                    <li>
                                        <h4 class="entry-title">
                                            <a name="compilations-cura1" href="{{ url('hinario/2/CuraI') }}">
                                                <span class="nossa-blue">
                                                    Cura 1
                                                </span>
                                            </a>
                                        </h4>
                                    </li>
                                    <li>
                                        <h4 class="entry-title">
                                            <a name="compilations-cura2" href="{{ url('hinario/3/Cura2') }}">
                                                <span class="nossa-blue">
                                                    Cura 2
                                                </span>
                                            </a>
                                        </h4>
                                    </li>
                                    <li>
                                        <h4 class="entry-title">
                                            <a name="compilations-cruzeirinho" href="{{ url('hinario/6/Cruzeirinho') }}">
                                                <span class="nossa-blue">
                                                    Cruzeirinho
                                                </span>
                                            </a>
                                        </h4>
                                    </li>
                                    <li>
                                        <h4 class="entry-title">
                                            <a name="compilations-chamados" href="{{ url('hinario/89/CahamdosDoSãoMiguel') }}">
                                                <span class="nossa-blue">
                                                    Chamados do Saão Miguel
                                                </span>
                                            </a>
                                        </h4>
                                    </li>
                                    <li>
                                        <h4 class="entry-title">
                                            <a name="compilations-preces" href="{{ url('hinario/61/Preces') }}">
                                                <span class="nossa-blue">
                                                    Oração
                                                </span>
                                            </a>
                                        </h4>
                                    </li>
                                    <li>
                                        <h4 class="entry-title">
                                            <a name="compilations-despacho" href="{{ url('hinario/4/HinosDoDespacho') }}">
                                                <span class="nossa-blue">
                                                    Hinos do Despacho
                                                </span>
                                            </a>
                                        </h4>
                                    </li>
                                </ul>
                        </div>
                    </div>
                </li>

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

                <h5>{{ __('hinarios.individuals.right_column.compilations') }}</h5>
                <ul class="list1 no-bullets">
                    <li><a href="#compilations-oracao">Oração</a></li>
                    <li><a href="#compilations-concentration">Concentração</a></li>
                    <li><a href="#compilations-cura1">Cura 1</a></li>
                    <li><a href="#compilations-cura2">Cura 2</a></li>
                    <li><a href="#compilations-cruzeirinho">Cruzeirinho</a></li>
                    <li><a href="#compilations-chamados">Chamados de São Miguel</a></li>
                    <li><a href="#compilations-preces">Preces</a></li>
                    <li><a href="#compilations-hinos do Despacho">Hinos do Despacho</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- eof aside sidebar -->

@endsection
