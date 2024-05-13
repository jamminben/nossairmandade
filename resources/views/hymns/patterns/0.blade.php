<div class="hymnstanza">
    <div class="hymn-title">
        <h5>
            {{ $hymn->getName($language) }}
        </h5>
    </div>
</div>

@include('hymns.partials.notation')

@include('hymns.patterns.print.0', [ 'stanzas' => $hymn->stanzas($language) ])
