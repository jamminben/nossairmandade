@if (count($hymn->getRecordings()) > 0)
    <div class="col-sm-12 col-md-12 text-left">
        @include('hymns.partials.audio_file_display', ['mediaFile' => $hymn->getRecordings()[0]])

        <div id="players" class="panel-group collapse-unstyled">
            <div class="panel">
                @if (count($hymn->getRecordings()) > 1)
                    <h4 class="poppins hinario-breadcrumb">
                        <a data-toggle="collapse" data-parent="#players" href="#collapseOthers" class="collapsed">{{ __('hymns.more_recordings') }}</a>
                    </h4>

                    <div id="collapseOthers" class="panel-collapse collapse in">
                        <div class="panel-content hymn-players-panel">
                            @foreach ($hymn->getRecordings() as $recording)
                                @if (!$loop->first)
                                    @include('hymns.partials.audio_file_display', ['mediaFile' => $recording])
                                    @if (!$loop->last)
                                        <br>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
                <script>
                    jQuery('audio').panzer({
                        showduration: true,
                        showdownload: true,
                        theme: 'light'
                    });
                </script>
            </div>
        </div>
    </div>
@else
    <div class="col-sm-12 col-md-12 text-left">
        {{ __('hymns.missing_audio') }}
    </div>
@endif
