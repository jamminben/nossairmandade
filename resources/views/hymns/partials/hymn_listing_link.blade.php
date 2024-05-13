<a href="{{ url($hymn->getSlug()) }}">
    {{ $hymn->getNumber($hinario->id) }}. {{ $hymn->getName($hymn->original_language_id) }}
    @if ($hymn->getName($hymn->original_language_id) != $hymn->getName())
        - {{ $hymn->getName() }}
    @endif
</a>
