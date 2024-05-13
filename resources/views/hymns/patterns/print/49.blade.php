@foreach($stanzas as $stanza)
    @if ($loop->iteration == 2)
        <br>
        <div class="hymnstanza">
            <div class="hymn-bar-empty">
                <div class="hymn-words">
                    @foreach($stanza->getLines() as $line)
                        @if ($loop->index == 2)
                </div>
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
        <div class="hymnstanza">
            <div class="hymn-bar-empty">
                <div class="hymn-words">
                    @foreach($stanza->getLines() as $line)
                        {{ $line }}<br>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endforeach
