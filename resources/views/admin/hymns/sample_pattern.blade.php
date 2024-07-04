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
    <div class="col-sm-8 col-md-8">
        <div class="container">
    <div class="row">
    <div class="col-sm-4 col-md-4">
        <div class="tab-content tab-unstyled">
            <div class="tab-pane fade in active notranslate" id="tab-unstyled-1000">
                @include('hymns.patterns.print.' . $pattern->pattern_id, [ 'stanzas' => $pattern->getSampleText() ])
            </div>
        </div>
    </div>
    </div>
        </div>
    </div>
    </body>
</html>
