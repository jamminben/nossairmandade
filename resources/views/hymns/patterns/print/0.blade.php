@foreach($stanzas as $stanza)
    <div class="hymnstanza">
        <div class="hymn-words">
            @foreach($stanza->getLines() as $line)
                {{ $line }}<br>
            @endforeach
        </div>
    </div>
    @if (!$loop->last)
        <br>
    @endif
@endforeach
