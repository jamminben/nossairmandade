<div class="hymnstanza">
    <div class="hymn-bar-empty">
        <div class="hymn-bar-empty">
            <div class="hymn-title">
                <h5>
                    {{ $hymn->getName($language) }}
                </h5>
            </div>
        </div>
    </div>
</div>

@include('hymns.partials.notation')

@include('hymns.patterns.print.71', [ 'stanzas' => $hymn->stanzas($language) ])
