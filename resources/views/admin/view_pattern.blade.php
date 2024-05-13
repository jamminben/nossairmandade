@extends('admin.layouts.app')

@section('header_title')
    View Pattern
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">View Pattern</h2>
@endsection

@section('extra_styles')
    <link rel="stylesheet" href="/css/hymns.css">
    <link rel="stylesheet" href="/css/hinarios.css">
@endsection

@section('content')
    <div class="col-sm-2">
        <div class="row">
            @foreach(array_keys($patterns) as $patternId)
                @if ($patterns[$patternId] == 1)
                    <a href="{{ url('/admin/view-pattern/' . $patternId) }}">View Pattern {{ $patternId }}</a><br>
                @else
                    Pattern {{ $patternId }} not done yet<br>
                @endif
            @endforeach
        </div>
    </div>


    <div class="col-sm-1"></div>
    <div class="col-sm-8">
        @if (!empty($hymn))
        <div class="row">
            <h4>Pattern {{ $hymn->pattern_id }}</h4>
            @if (view()->exists('hymns.patterns.' . $hymn->pattern_id))
                <div class="col-sm-6 col-md-6">
                    <div class="tab-content tab-unstyled">
                        <div class="tab-pane fade in active" id="tab-unstyled-1000">
                            @include ('hymns.patterns.' . $hymn->pattern_id, [ 'language' => $hymn->original_language_id ])
                        </div>
                    </div>
                </div>
            @else
                <h4>View does not exist yet</h4>
            @endif
        </div>
        @endif

        @if (!empty($hymns))
            @foreach ($hymns as $hymnRow)
                <div class="row">
                    <h4>Pattern {{ $hymnRow->pattern_id }}</h4>
                    @if (view()->exists('hymns.patterns.' . $hymnRow->pattern_id))
                        <div class="col-sm-6 col-md-6">
                            <div class="tab-content tab-unstyled">
                                <div class="tab-pane fade in active" id="tab-unstyled-1000">
                                    @include ('hymns.patterns.' . $hymnRow->pattern_id, [ 'language' => $hymnRow->original_language_id, 'hymn' => $hymnRow ])
                                </div>
                            </div>
                        </div>
                    @else
                        <h4>View does not exist yet</h4>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

@endsection
