@foreach($stanzas as $stanza)
    @if ($loop->first)
        <div class="hymnstanza">
            <div class="hymn-bar-full">
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
        </div>
        <br>
        <div class="hymn-spacer">&nbsp;</div>
    @elseif ($loop->iteration == 2)
        <div class="hymnstanza">
            <div class="hymn-bar-empty">
                <div class="hymn-bar-empty">
                    <div class="hymn-bar-full">
                        <div class="hymn-words">
                            @foreach($stanza->getLines() as $line)
                                @if ($loop->index == 2)
                        </div>
                    </div>
                </div>
            </div>
            <div class="hymn-bar-empty">
                <div class="hymn-bar-empty">
                    <div class="hymn-bar-empty">
                        <div class="hymn-spacer">&nbsp;</div>
                    </div>
                </div>
            </div>
            <div class="hymn-bar-empty">
                <div class="hymn-bar-empty">
                    <div class="hymn-bar-full">
                        <div class="hymn-words">
                                @endif
                                {{ $line }}<br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <br>
        <div class="hymnstanza">
            <div class="hymn-bar-empty">
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
        </div>
    @endif
@endforeach
