<div class="audio-file-display">
    <div class="audio-player-line">
        <div class="audio-player">
            <audio controls id="top_player">
                <source src="{{ $mediaFile->url }}" type="audio/mpeg" />
                <!-- <source src="path-to-preview.ogg" type="audio/ogg" /> -->
            </audio>
        </div>
        <div style="display: inline-block; padding-left: 30px">
            <select name="actions_{{ $mediaFile->id }}" id="actions_{{ $mediaFile->id }}">
                <option value="">select action</option>
                <option value="delete">{{ __('hymns.edit.delete_file_from_hymn_label') }}</option>
                <option value="mark_official">{{ __('hymns.edit.mark_as_official_label') }}</option>
                <option value="unmark_official">{{ __('hymns.edit.unmark_as_official_label') }}</option>
            </select>
        </div>
    </div>
    <div class="audio-info">
        <div class="audio-source">
            {{ __('hymns.recording_source') }}:
            <a href="{{ $mediaFile->source->url }}" target="_blank">
                {{ __($mediaFile->source->getDescription()) }}
                @if ($isOfficial)
                    - <strong>{{ __('hymns.is_official') }}</strong>
                @endif
            </a>
        </div>
    </div>
</div>
