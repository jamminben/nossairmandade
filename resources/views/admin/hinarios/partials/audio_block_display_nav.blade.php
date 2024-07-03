@if (isset($hinario->recordingSources) && count($hinario->recordingSources) > 0)
    <div class="row vertical-tabs color4">
        <!-- Nav tabs -->
        <ul class="nav less-padding" role="tablist">
            @foreach ($hinario->recordingSources as $source)
            <li @if ($loop->first) class="active" @endif>
                <a href="#vertical-tab{{ $source->id }}" role="tab" data-toggle="tab">
                    {{ $source->description }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
@endif
