@if (count($entity->getOtherMedia()) > 0)
    <ul class="list2 downloadlist">
        @foreach ($entity->getOtherMedia() as $media)
            <li>
                <a href="{{ url($media->url) }}" target="_blank">{{ $media->filename }}</a><br>
                {{ __('hinarios.source') }} <a href="{{ $media->source->url }}" target="_blank">{{ $media->source->getDescription() }}</a>
                <br><input type="checkbox" name="delete_media_file_{{ $media->id }}"> {{ __('hinarios.delete_media') }}
            </li>
        @endforeach
    </ul>
@endif
