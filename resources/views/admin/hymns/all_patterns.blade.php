@section('extra_styles')
    <link rel="stylesheet" href="/css/hymns.css">
    <link rel="stylesheet" href="/css/hinarios.css">
@endsection
<!DOCTYPE html>
<html>
    <head>

        @include('layouts.partials.head')
        @yield('css')

    </head>

    <body>
        <div class="col-sm-3 col-md-3">
            <div class="container">
                @foreach ($patterns as $pattern)
                <div class="row">
                    <div class="col-sm-4 col-md-4"></div>
                    <div class="col-sm-4 col-md-4">
                        <div class="tab-content tab-unstyled">
                            <div class="tab-pane fade in active notranslate" id="tab-unstyled-1000">
                                <h4>#{{ $pattern->pattern_id }}</h4>
                                @include('hymns.patterns.print.' . $pattern->pattern_id, [ 'stanzas' => $pattern->getSampleText(), 'pageNumber' => 1 ])
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </body>
</html>
