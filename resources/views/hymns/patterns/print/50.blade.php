@foreach($stanzas as $stanza)
    @if ($loop->first)
        <div class="hymnstanza">
            <div class="hymn-bar-full">
                <div class="hymn-bar-empty">
                    @foreach($stanza->getLines() as $line)
                @if ($loop->iteration == 1)
                    <div class="hymn-words">
                @endif
                    @if ($loop->iteration == 1 || $loop->iteration == 2 || $loop->iteration == 3 || $loop->iteration == 4 || $loop->iteration == 5 || $loop->iteration == 6 || $loop->iteration == 7)
                        {{ $line }}<br>
                    @endif
                @if ($loop->iteration == 7)
                    </div>
                </div><br>
                @endif
                @if ($loop->iteration == 8)
                <div class="hymn-bar-full">
                    <div class="hymn-words">
                @endif
                        @if ($loop->iteration == 8 || $loop->iteration == 9 || $loop->iteration == 10)
                            {{ $line }}<br>
                        @endif
                @if ($loop->iteration == 10)
                    </div>
                @endif
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <br>
        <div class="hymnstanza">
            <div class="hymn-bar-empty">
                <div class="hymn-bar-empty">
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
