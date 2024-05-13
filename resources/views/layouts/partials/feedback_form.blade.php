<div class="widget widget_mailchimp col-sm-10 col-lg-12">
    <h3 class="widget-title">{{ __('universal.feedback_form.header') }}</h3>
    <p class="fontsize_14">{{ __('universal.feedback_form.description') }}</p>
    @if (\Illuminate\Support\Facades\Auth::check())
    <form class="feedback" action="{{ url('/submit-feedback') }}" method="GET">
        <div class="form-group-sm">
            <div class="form-group">
                <label for="feedback_messsage" class="sr-only">{{ __('universal.feedback_form.header') }}</label>
                <textarea name="feedback_message" aria-required="true" rows="3" cols="10" id="feedback_message" class="form-control feedback_message" placeholder="{{ __('universal.feedback_form.message_placeholder') }}"></textarea>
            </div>
        </div>
        <div class="form-group-sm">
            <div class="feedback-form-button">
            <input type="hidden" name="entity_type" value="{{ $entityType }}" class="entity_type">
            <input type="hidden" name="entity_id" value="{{ $entityId }}" class="entity_id">
            <button type="submit" class="theme_button color4 margin_0">{{ __('universal.feedback_form.submit') }}</button>
            </div>
        </div>
        <div class="feedback_response" id="feedback_response"></div>
    </form>
    @else
        <p class="fontsize_14">{!! __('universal.feedback_form.login') !!}</p>
    @endif
</div>
