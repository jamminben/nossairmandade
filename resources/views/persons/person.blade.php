@extends('layouts.app')

@section('header_title')
    {{ $person->display_name }}
@endsection

@section('page_title')
    <h2 class="small display_table_cell_md">{{ $person->display_name }}</h2>
@endsection

@section('controls')
    @can('edit_person_' . $person->id)
        <div class="col-4 text-right" title="Edit Person" id="editSection">
            <div class="col-4 text-right" title="Edit Person" id="editSection">
                <button id="editButton" class="btn btn-warning btn-sm">
                    <div style="display: inline-block"><h4><i class="fas fa-pencil-square-o"></i></h4></div>
                    <div style="display: inline-block; width: 50px;"><span>{{ __('person.edit_button') }}</span></div>
                </button>
            </div>
        </div>
    @endcan
@endsection

@section('content')
    <div class="col-sm-8 col-md-8 col-lg-8">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-lg-4 small-portrait">
                    <img src="{{ url($person->getPortrait()) }}" alt="{{ $person->display_name }}"
                         class="alignleft rounded">
                </div>
                <div class="col-sm-1 col-lg-1"></div>
                <div class="col-sm-7 col-lg-7">
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
            @if (count($person->hinarios) > 0 || count($person->localHinarios) > 0)
                <h5>{{ __('person.right_column.hinarios') }}</h5>
                <ul class="list1 no-bullets">
                    @foreach ($person->hinarios as $hinario)
                        <li>
                            <a href="{{ url($hinario->getSlug()) }}">{{ $hinario->getName($hinario->original_language_id) }}</a>
                        </li>
                    @endforeach
                    @foreach ($person->localHinarios as $hinario)
                        <li>
                            <a href="{{ url($hinario->getSlug()) }}">{{ $hinario->getName($hinario->original_language_id) }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
            @include('layouts.partials.other_media', [ 'entity' => $person ])

            @include('layouts.partials.feedback_form', [ 'entityType' => 'persons.person', 'entityId' => $person->id ])
        </div>
    </div>
    <!-- eof aside sidebar -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#editButton').click(function() {
                window.location.href = '{{ url('edit-person/' . $person->id) }}';
            });
        });
    </script>
@endsection

