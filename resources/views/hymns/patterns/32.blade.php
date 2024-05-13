<div class="hymnstanza">
    <div class="hymn-bar-empty">
        <span style="float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
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
</div>

@include('hymns.partials.notation')

@include('hymns.patterns.print.32', [ 'stanzas' => $hymn->stanzas($language) ])
