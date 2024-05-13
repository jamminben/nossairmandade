@if (!empty($hymnListHeading))
<h4>{{ $hymnListHeading }}</h4>
@endif

@foreach ($hymnTranslations as $hymnTranslation)
    <div class="row">
        <div class="hymn-list-number">{{ $loop->iteration }}</div>
        <div class="inline-block bottompadding_20">
            <div class="hymn-list-name">
                <a href="{{ url($hymnTranslation->hymn->getSlug()) }}">{{ mb_convert_case($hymnTranslation->name, MB_CASE_TITLE, "UTF-8") }}</a>
            </div>
            <p>
                {{ $hymnTranslation->hymn->receivedBy->display_name }}
                @if (!empty($hymnTranslation->hymn->receivedHinario))
                    - {{ $hymnTranslation->hymn->receivedHinario->getName() }} #{{ $hymnTranslation->hymn->received_order }}
                @endif
            </p>
        </div>
    </div>
@endforeach
