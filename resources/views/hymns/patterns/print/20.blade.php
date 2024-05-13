@foreach($stanzas as $stanza)
    @if ($loop->first)
        <div class="hymnstanza">
            @foreach($stanza->getLines() as $line)
                @if ($loop->first)
                    <div class="hymn-bar-empty">
                        <div class="hymn-bar-empty">
                            <div class="hymn-bar-full">
                                <div class="hymn-words">
                    @endif
                            @if ($loop->iteration == 1 || $loop->iteration == 2)
                                {{ $line }}<br>
                            @endif
                            @if ($loop->iteration == 2)
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="hymn-bar-empty">
                    <div class="hymn-spacer">&nbsp;</div>
                </div>
                        @endif
                @if ($loop->iteration == 3)
                <div class="hymn-bar-full">
                    <div class="hymn-bar-full">
                        <div class="hymn-bar-full">
                                <div class="hymn-words">
                    @endif
                            @if ($loop->iteration == 3 || $loop->iteration == 4)
                                {{ $line }}<br>
                            @endif
                            @if ($loop->iteration == 4)
                                </div>
                        </div>
                    </div>
                </div>
        </div>
                        @endif
                    @endforeach
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
