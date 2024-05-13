<div class="audio-file-display">
    <div class="audio-player-line">
        <div class="audio-player">
            <audio controls id="top_player">
                <source src="{{ $mediaFile->url }}" type="audio/mpeg" />
                <!-- <source src="path-to-preview.ogg" type="audio/ogg" /> -->
            </audio>
        </div>
        <div class="audio-vote">
            @if (\Illuminate\Support\Facades\Auth::check())
                <div class="vote-takers-{{ $mediaFile->id }}" style="display: inline-block">
                    @if (!$mediaFile->hasUpvote(\Illuminate\Support\Facades\Auth::user()->id))
                        <div class="upvote-taker-{{ $mediaFile->id }}">
                            <a class="upvote_{{ $mediaFile->id }}">
                                <i class="far fa-thumbs-up"></i>
                            </a>
                        </div>
                        <div class="downvote-taker-{{ $mediaFile->id }}"></div>
                    @else
                        <div class="upvote-taker-{{ $mediaFile->id }}"></div>
                        <div class="downvote-taker-{{ $mediaFile->id }}">
                            <a class="downvote_{{ $mediaFile->id }}">
                                <i class="fas fa-thumbs-up"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endif
            <div class="upvote-count">
            @if (count($mediaFile->upvotes))
                {{ $mediaFile->getOtherUpvotesCount(
                    \Illuminate\Support\Facades\Auth::check() ?
                    \Illuminate\Support\Facades\Auth::user()->id : 0) }}
                @if ($mediaFile->getOtherUpvotesCount(
                    \Illuminate\Support\Facades\Auth::check() ?
                    \Illuminate\Support\Facades\Auth::user()->id : 0) == 1)
                    {{ __('hymns.other_likes_this') }}
                @else
                    {{ __('hymns.others_like_this') }}
                @endif
            @endif
            </div>
            <div class="upvote-tooltip">
                <a data-toggle="tooltip" title="{!! __('hymns.upvote_tooltip') !!}">
                    <i class="far fa-question-circle"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="audio-info">
        <div class="audio-source">
            {{ __('hymns.recording_source') }}:
            <a href="{{ $mediaFile->source->url }}" target="_blank">
                {{ __($mediaFile->source->getDescription()) }}
            </a>
        </div>
    </div>
</div>
@if (\Illuminate\Support\Facades\Auth::check())
<script>
    jQuery('.vote-takers-{{ $mediaFile->id }}').click(function( e ) {
        e.preventDefault();
        var $form = jQuery(this);
        $upvoteHtml = $form.find('.upvote-taker-{{ $mediaFile->id }}').html();
        if ($upvoteHtml.length > 0) {
            // Prepare query string and send AJAX request
            jQuery.ajax({
                url: '/submit-upvote',
                data: 'ajax=true&media_file_id={{ $mediaFile->id }}',
                success: function (msg) {
                    $form.find('.upvote-taker-{{ $mediaFile->id }}').html('');
                    $form.find('.downvote-taker-{{ $mediaFile->id }}').html(msg);
                }
            });
        } else {
            jQuery.ajax({
                url: '/submit-downvote',
                data: 'ajax=true&media_file_id={{ $mediaFile->id }}',
                success: function (msg) {
                    $form.find('.downvote-taker-{{ $mediaFile->id }}').html('');
                    $form.find('.upvote-taker-{{ $mediaFile->id }}').html(msg);
                }
            });
        }
    });
</script>
@endif
