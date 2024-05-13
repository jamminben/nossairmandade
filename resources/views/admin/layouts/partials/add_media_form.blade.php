<h3 class="widget-title">Add Media</h3>
<form class="add_media" action="{{ url('/admin/add-media') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group-sm">
        <div class="form-group">
            <label for="new_media" class="sr-only">Add Media</label>
            <input type="file" class="form-control " name="new_media" id="new_media" placeholder="Choose File" value="">
            <select name="source_id">
                <option value="">Select Source</option>
                @foreach ($allMediaSources as $source)
                    <option value="{{ $source->media_source_id }}">{{ $source->description }} @if (!empty($source->url)) ({{ $source->url }}) @endif</option>
                @endforeach
            </select>
            <input type="text" name="new_source_description" placeholder="New Source Name">
            <input type="text" name="new_source_url" placeholder="New Source Url">
        </div>
    </div>
    <div class="form-group-sm">
        <div class="feedback-form-button">
            <input type="hidden" name="entity_type" value="{{ $entityType }}" class="entity_type">
            <input type="hidden" name="entity_id" value="{{ $entityId }}" class="entity_id">
            <button type="submit" class="theme_button color4 margin_0">Add Media</button>
        </div>
    </div>
</form>

