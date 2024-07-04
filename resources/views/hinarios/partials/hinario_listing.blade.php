
    <h4><a href="{{ url($hinario->getSlug()) }}">{{ $hinario->getName($hinario->original_language_id) }}
        @if ($hinario->type_id == 2 && !is_null($hinario->receivedBy))
            - {{ $hinario->receivedBy->display_name }}
        @endif
        </a></h4>
    <p>{{ $hinario->getDescription() }}</p>
