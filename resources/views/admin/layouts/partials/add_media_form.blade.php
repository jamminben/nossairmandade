<style>
    .tooltip-text {
        visibility: hidden;
        position: absolute;
        z-index: 2;
        width: 200px;
        color: white;
        font-size: 12px;
        line-height: 1.5em;
        background-color: #192733;
        border-radius: 10px;
        padding: 10px 15px 10px 15px;
    }

    .tooltip-text::before {
        content: "";
        position: absolute;
        transform: rotate(45deg);
        background-color: #192733;
        padding: 5px;
        z-index: 1;
    }

    .add_media_tooltip:hover .tooltip-text {
        visibility: visible;
    }

    #top {
        top: -40px;
        left: -50%;
    }

    #top::before {
        top: 80%;
        left: 45%;
    }

    #bottom {
        top: 25px;
        left: -50%;
    }

    #bottom::before {
        top: -5%;
        left: 45%;
    }

    #left {
        top: -8px;
        right: 120%;
    }

    #left::before {
        top: 35%;
        left: 94%;
    }

    #right {
        top: -8px;
        left: 120%;
    }

    #right::before {
        top: 10%;
        left: -2%;
    }

    .add_media_tooltip {
        position: relative;
        display: inline-block;
        text-align: left;
    }
</style>
<h3 class="widget-title">{{ __('universal.add_media.add_media') }} <div class="add_media_tooltip"><i class="fas fa-question-circle"></i><span class="tooltip-text" id="right">{{ __('universal.add_media.add_media_tooltip_text') }}</span></div></h3>

<div class="form-group-sm">
    <div class="form-group">
        <label for="new_media" class="sr-only">{{ __('universal.add_media.add_media') }}</label>
        <input type="file" class="form-control " name="new_media" id="new_media" placeholder="{{ __('universal.add_media.choose_file') }}" value="">
        <br>{{ __('universal.add_media.add_new_source_label') }}<br>
        <input type="text" name="new_source_description" placeholder="{{ __('universal.add_media.new_source_name') }}">
        <input type="text" name="new_source_url" placeholder="{{ __('universal.add_media.new_source_url') }}">
    </div>
</div>
