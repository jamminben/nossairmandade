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
    @elseif ($loop->iteration == 2)
        <br>
        <div class="hymnstanza">
            @foreach($stanza->getLines() as $line)
                @if ($loop->iteration == 1)
                    <div class="hymn-bar-full">
                        <div class="hymn-words">
                @elseif ($loop->iteration == 3)
                        </div>
                    </div>
                    <div class="hymn-bar-empty">
                        <div class="hymn-words">
                @elseif ($loop->iteration == 4)
                        </div>
                    </div>
                    <div class="hymn-bar-full">
                        <div class="hymn-words">
                @endif
                        {{ $line }}<br>
                @if ($loop->iteration == 5)
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
