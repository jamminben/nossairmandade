@if ($pageNumber == 1)
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
        @endif
    @endforeach
@else
    @foreach ($stanzas as $stanza)
        @if (!$loop->first)
            <br>
        @endif
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
    @endforeach
@endif
