@if (count($entity->getOtherMedia()) > 0)
    <ul class="list2 downloadlist">
        @foreach ($entity->getOtherMedia() as $media)
            <li>
                <a href="{{ url($media->url) }}">{{ $media->filename }}</a><br>
                {{ __('hinarios.source') }} <a href="{{ $media->source->url }}" target="_blank">{{ $media->source->getDescription() }}</a>
            </li>
        @endforeach
    </ul>
@endif
