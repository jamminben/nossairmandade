@foreach($stanzas as $stanza)
    @if ($loop->first)
        <div class="hymnstanza">
        @foreach($stanza->getLines() as $line)
            @if ($loop->iteration == 1 || $loop->iteration == 4)
                <div class="hymn-bar-full">
                    <div class="hymn-words">
            @elseif ($loop->iteration == 3)
                <div class="hymn-bar-empty">
                    <div class="hymn-words">
            @endif
                            {{ $line }}<br>
            @if ($loop->iteration == 2 || $loop->iteration == 3 || $loop->iteration == 5)
                    </div>
                </div>
            @endif
        @endforeach
        </div>
    @else
        <br>
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
