@foreach($stanzas as $stanza)
    @if (in_array($loop->iteration, [1,2,5,6]))
        @if (!$loop->first)
            <br>
        @endif
        <div class="hymnstanza">
            <div class="hymn-bar-full">
                <div class="hymn-bar-full">
                    <div class="hymn-words">
                        @foreach($stanza->getLines() as $line)
                            {{ $line }}<br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <br>
        <div class="hymnstanza">
            <div class="hymn-bar-empty">
                <div class="hymn-bar-full">
                    <div class="hymn-words">
                        @foreach($stanza->getLines() as $line)
                            {{ $line }}<br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
