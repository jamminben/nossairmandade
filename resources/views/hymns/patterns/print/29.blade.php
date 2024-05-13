@foreach($stanzas as $stanza)
    @if ($loop->iteration == 11 || $loop->iteration == 12 || $loop->iteration == 13)
        <br>
        <div class="hymnstanza">
            <div class="hymn-bar-full">
                <div class="hymn-words">
                    @foreach($stanza->getLines() as $line)
                        {{ $line }}<br>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        @if (!$loop->first)
            <br>
        @endif
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
