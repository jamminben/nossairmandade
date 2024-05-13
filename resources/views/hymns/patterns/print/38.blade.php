@foreach($stanzas as $stanza)
    @if ($loop->first)
        <div class="hymnstanza">
            <div class="hymn-bar-full">
                <div class="hymn-bar-empty">
    @elseif ($loop->iteration == 2)
        <div class="hymn-bar-full">
            <div class="hymn-bar-full">
    @else
        <br>
        <div class="hymnstanza">
            <div class="hymn-bar-empty">
                <div class="hymn-bar-empty">
    @endif
                    <div class="hymn-words">
                        @foreach($stanza->getLines() as $line)
                            {{ $line }}<br>
                        @endforeach
                        @if ($loop->first)
                            <br>
                        @endif
                    </div>
                </div>
        @if ($loop->iteration != 1)
            </div>
        @endif
        </div>
@endforeach
