<div class="center" style="line-height: .5em;">
    <strong>
        @if (get_class($hinario) == \App\Models\UserHinario::class)
            {{ $hymn->getNumberUserHinario($hinario->id) }}.
        @else
            {{ $hymn->getNumber($hinario->id) }}.
        @endif
        {{ mb_convert_case($hymn->getName($language), MB_CASE_UPPER, 'UTF-8') }}
    </strong> ({{ __('hymns.header.continued') }})
</div>
<hr>
<p class="center" style="margin: 0px; line-height: .8em !important; padding-bottom: 5px;">
@if ($hinario->type_id == 3 ||
    (
        !empty($hinario->personLocalHinario) &&
        $hymn->received_by != $hinario->personLocalHinario->person_id
    ) ||
    get_class($hinario) == \App\Models\UserHinario::class
)
    {{ $hymn->receivedBy->display_name }} #{{ $hymn->received_order }}
@endif
@if (!empty($hymn->offeredTo))
    <br>({{ __('hymns.header.offered_to') }} {{ $hymn->offeredTo->display_name }})
@endif
</p>

@if (!empty($hymn->getNotation($language)))
    <div style="margin: 0px; line-height: 1em;">
        @include('hymns.partials.print.notation')
    </div>
@else
    <div style="margin: 0px; line-height: 1em;">
        @include('hymns.partials.print.blank_notation')
    </div>
@endif
