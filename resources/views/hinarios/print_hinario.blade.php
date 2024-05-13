
    @php
        $sectionName = ''
    @endphp
    @foreach ($hinario->hymnHinarios as $hymnHinario)
        @if ($hymnHinario->getSection()->getName() != $sectionName)
            <p class="center large">{{ $hymnHinario->getSection()->getName() }}</p>
            <p style="page-break-before: always"></p>
            @php
                $sectionName = $hymnHinario->getSection()->getName()
            @endphp
        @endif

        <p class="center"><strong>{{ $hymnHinario->list_order }}. {{ mb_convert_case($hymnHinario->hymn->getName($hymnHinario->hymn->original_lanaguage_id), MB_CASE_TITLE, 'UTF-8') }}</strong></p>
        @if ($hymnHinario->hinario->type_id == 3 ||
            (
                !empty($hymnHinario->hinario->personLocalHinario) &&
                $hymnHinario->hymn->received_by != $hymnHinario->hinario->personLocalHinario->person_id
            )
        )
            <p class="center">{{ $hymnHinario->hymn->receivedBy->display_name }} #{{ $hymnHinario->hymn->received_order }}</p>
        @endif
        <br>
        @if (!empty($hymnHinario->hymn->offeredTo))
            ({{ __('hymns.header.offered_to') }} {{ $hymnHinario->hymn->offeredTo->display_name }}
        @endif

        @if (view()->exists('hymns.patterns.print.' . $hymnHinario->hymn->pattern_id))
            @include('hymns.patterns.print.' . $hymnHinario->hymn->pattern_id, [ 'hymn' => $hymnHinario->hymn, 'language' => $hymnHinario->hymn->original_language_id ])
        @else
            @include('hymns.patterns.print.0', [ 'hymn' => $hymnHinario->hymn, 'language' => $hymnHinario->hymn->original_language_id ])
        @endif

        <p class="center">
        <img src="{{ url('/images/print/sun_moon_stars.jpg') }}" width="75px">
        </p>

        <p style="page-break-before: always"></p>
    @endforeach

</body>
</html>
