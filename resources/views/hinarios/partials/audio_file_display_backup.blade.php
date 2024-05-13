<div class="audio-file-display">
    <div class="audio-player-line">
        <div class="audio-player">
            @php
                $hymnCount = 0;
            @endphp
            @foreach ($hinario->hymns as $hymn)
                @if (!empty($hymn->getRecording($source->id)))
                    <audio controls preload="metadata" title="{{ $hymn->getNumber($hinario->id) }}. {{ mb_convert_case($hymn->getName($hymn->original_language_id), MB_CASE_UPPER, 'UTF-8') }}" class="playlist_{{ $source->id }}">
                        <source src="{{ $hymn->getRecording($source->id)->url }}" type="audio/mpeg" />
                        <!-- <source src="path-to-preview.ogg" type="audio/ogg" /> -->
                    </audio>
                    @php
                        $hymnCount++;
                    @endphp
                @endif
            @endforeach
                <script>
                    jQuery('audio.playlist_{{ $source->id }}').panzerlist({
                        title: '{{ $hinario->getName($hinario->original_language_id) }} - {{ $source->getDescription() }}',
                        showdownload: true,
                        theme: 'light',
                        layout: 'big',
                        showvolume: false,
                        show_prev_next: true,
                        @if ($hymnCount > 1)
                            downloadtarget: '/public/media/hinarios/{{ $hinario->id }}/{{ $source->id }}/{{ $hinario->getName($hinario->original_language_id) }}.zip',
                            downloadtitle: '{{ __('hinarios.download_button') }}'
                        @endif
                    });
                </script>
        </div>
    </div>
</div>
<div class="hinario-recording-source">
    {{ __('hinarios.source') }} <a href="{{ $source->url }}" target="_blank">{{ $source->getDescription() }}</a>
</div>
