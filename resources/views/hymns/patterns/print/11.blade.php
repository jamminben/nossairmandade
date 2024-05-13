@foreach($stanzas as $stanza)
    @if ($loop->first)
        <div class="hymnstanza">
            <div class="hymn-bar-full">
                <div class="hymn-words">
    @endif
                    @if ($loop->iteration == 1 || $loop->iteration == 2)
                        @foreach($stanza->getLines() as $line)
                            {{ $line }}<br>
                        @endforeach
                        @if ($loop->first)
                            <br>
                        @endif
                    @endif
    @if ($loop->iteration == 2)
                </div>
            </div>
        </div>
    @endif
    @if ($loop->iteration != 1 && $loop->iteration != 2)
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
