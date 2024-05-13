@if (isset($hinario->recordingSources) && count($hinario->recordingSources) > 0)
    <div class="vertical-tabs color3">
        <div class="tab-content hinario-player-tab" style="background-color: white;">
            @foreach ($hinario->recordingSources as $source)
                <div class="tab-pane @if ($loop->first) fade in active @endif" id="vertical-tab{{ $source->id }}">
                    @include('hinarios.partials.audio_file_display', [ 'hinario' => $hinario, 'source' => $source, 'sourceId' => $source->id, 'first' => $loop->first ])
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="col-sm-12 col-md-12 text-left">
        {{ __('hymns.missing_audio') }}
    </div>
@endif
