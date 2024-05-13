@if (count($hinario->otherMedia) > 0)
    <ul class="list2 downloadlist">
        @foreach ($hinario->otherMedia as $media)
            <li>
                <a href="{{ url($media->url) }}">{{ $media->filename }}</a><br>
                {{ __('hinarios.source') }} <a href="{{ $media->source->url }}" target="_blank">{{ $media->source->description }}</a>
            </li>
        @endforeach
    </ul>
@endif
