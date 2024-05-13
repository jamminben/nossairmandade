@foreach($stanzas as $stanza)
    @if ($loop->first)
        <div class="hymnstanza">
            <div class="hymn-bar-full">
                <div class="hymn-words">
                    @foreach($stanza->getLines() as $line)
                        @if ($loop->index == 2)
                </div>
            </div>
            <div class="hymn-bar-empty">
                <div class="hymn-spacer">&nbsp;</div>
            </div>
            <div class="hymn-bar-full">
                <div class="hymn-words">
                        @endif
                        {{ $line }}<br>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <br>
        <div class="hymnstanza">
            @if ($loop->iteration == 4)
                <div class="hymn-bar-full">
            @else
                <div class="hymn-bar-empty">
            @endif
                <div class="hymn-words">
                    @foreach($stanza->getLines() as $line)
                        {{ $line }}<br>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endforeach
