@extends('layouts.app')

@section('header_title')
    {{ $person->display_name }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ $person->display_name }}</h2>
@endsection

@section('content')
    <div class="col-sm-8 col-md-8 col-lg-8">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12 small-portrait">
                    <img src="{{ url($person->getPortrait()) }}" alt="{{ $person->display_name }}" class="alignleft rounded">
                    <p>
                        @if ($person->getDescription() == '')
                            {{ __('person.missing_description') }}
                        @else
                            {{ $person->getDescription() }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- sidebar -->
    <div class="col-sm-2 col-md-2 col-lg-2">
        <div class="row">
            @if (count($person->hinarios) > 0)
                <h5>{{ __('person.right_column.hinarios') }}</h5>
            @endif
            <ul class="list1 no-bullets">
                @foreach ($person->hinarios as $hinario)
                    <li><a href="{{ url($hinario->getSlug()) }}">{{ $hinario->getName($hinario->original_language_id) }}</a></li>
                @endforeach
            </ul>
            @include('layouts.partials.other_media', [ 'entity' => $person ])

            @include('layouts.partials.feedback_form', [ 'entityType' => 'person', 'entityId' => $person->id ])
        </div>
        <div class="row">
                <!-- add media form -->
                @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->hasRole('superadmin'))
                    @include('admin.layouts.partials.add_media_form', [ 'entityType' => 'person', 'entityId' => $person->id ])
                @endif
        </div>
    </div>
    <!-- eof aside sidebar -->
@endsection

