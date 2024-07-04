<div class="row">
@if (count($hymn->getRecordings()) > 0)
    <div class="col-sm-8 col-md-8 text-left">
        <div id="players" class="panel-group collapse-unstyled">
            <div class="panel">
                {{ __('hymns.edit.recordings') }}<br><br>

                    <div class="panel-content hymn-players-panel">
                        @foreach ($hymn->getRecordings() as $recording)
                                @include('admin.hymns.partials.audio_file_display', [ 'mediaFile' => $recording, 'isOfficial' => $hymn->isOfficial($recording->id) ])
                                @if (!$loop->last)
                                    <br>
                                @endif
                        @endforeach
                    </div>
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
@endif
    <div class="col-sm-4 col-md-4 text-left">
    @if (count($hymn->getOtherMedia()) > 0)
        <ul class="list2">
            @foreach ($hymn->getOtherMedia() as $media)
                <li>
                    <a href="{{ url($media->url) }}" target="_blank">{{ $media->filename }}</a><br>
                    {{ __('hinarios.source') }} <a href="{{ $media->source->url }}" target="_blank">{{ $media->source->getDescription() }}</a>
                    <br><input type="checkbox" name="delete_media_file_{{ $media->id }}"> {{ __('hymns.edit.delete_file_from_hymn_label') }}
                </li>
            @endforeach
        </ul>
    @endif


        @include('admin.layouts.partials.add_media_form', [ 'entityType' => 'hymn', 'entityId' => $hymn->id ])
    </div>
</div>
