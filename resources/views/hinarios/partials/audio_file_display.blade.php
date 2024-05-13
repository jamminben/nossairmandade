<div class="audio-file-display">
    <div class="audio-player-line">
        <div class="audio-player">
            @php
                $hymnCount = 0;
            @endphp
            @foreach ($hinario->hymns as $hymn)
                @if (!empty($hymn->recordings->$sourceId))
                    <audio controls preload="none" title="{{ $hymn->number }}. {{ $hymn->name }}" class="playlist_{{ $sourceId }}">
                        <source src="{{ asset($hymn->recordings->$sourceId->url) }}" type="audio/mpeg" />
                        <!-- <source src="path-to-preview.ogg" type="audio/ogg" /> -->
                    </audio>
                    @php
                        $hymnCount++;
                    @endphp
                @endif
            @endforeach
                <script @if (!$first) defer @endif>
                    jQuery('audio.playlist_{{ $sourceId }}').panzerlist({
                        title: '{{ $hinario->name }} - {{ $source->description }}',
                        showdownload: true,
                        theme: 'light',
                        layout: 'big',
                        showvolume: false,
                        show_prev_next: true,
                        @if ($hymnCount > 1)
                            downloadtarget: '/public/media/hinarios/{{ $hinario->id }}/{{ $sourceId }}/{{ $hinario->name }}.zip',
                            downloadtitle: '{{ __('hinarios.download_button') }}'
                        @endif
                    });
                </script>
        </div>
    </div>
</div>
<div class="hinario-recording-source">
    {{ __('hinarios.source') }} <a href="{{ $source->url }}" target="_blank">{{ $source->description }}</a>
</div>
