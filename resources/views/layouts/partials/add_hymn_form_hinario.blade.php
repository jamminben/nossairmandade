<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="caret add-hymn-dropdown"></span></a>
<ul id="login-dp" class="dropdown-menu extend-right">
    <li>
        <div class="row">
            <div class="col-md-12">
                <div class="help-block text-center">
                    {{ __('universal.add_hymn_form.header') }}
                    <a data-toggle="tooltip" title="{!! __('universal.add_hymn_form.add_tooltip') !!}" style="overflow: visible !important; font-size: inherit;">
                        <i class="far fa-question-circle"></i>
                    </a>
                </div>
                @foreach ($userHinarios as $userHinario)
                    <form class="add_hymn_{{ $hymn->id }}_to_{{ $userHinario->id }}" role="form" method="POST" action="{{ url('/add-hymn-to-user-hinario') }}" accept-charset="UTF-8" id="add-hymn-{{ $hymn->id }}-to-user-hinario-{{ $userHinario->id }}">
                    <div class="form-group">
                        @csrf
                        <input type="hidden" name="user_hinario_id" value="{{ $userHinario->id }}" class="user_hinario_id">
                        <input type="hidden" name="hymn_id" value="{{ $hymn->id }}" class="hymn_id">
                        <button type="submit" class="btn btn-primary btn-block add-hymn-button">{{ $userHinario->name }}</button>
                    </div>
                    <div class="add_hymn_{{ $hymn->id }}_to_{{ $userHinario->id }}_response add-hymn-response" id="add_hymn_{{ $hymn->id }}_to_{{ $userHinario->id }}_response"></div>
                    </form>

                    <script>
                        //Feedback form processing
                        jQuery('.add_hymn_{{ $hymn->id }}_to_{{ $userHinario->id }}').on('submit', function( e ) {
                            e.preventDefault();
                            var $form = jQuery(this);
                            // update user interface
                            $form.find('.add_hymn_{{ $hymn->id }}_to_{{ $userHinario->id }}_response').html('<span><i class="fas fa-ellipsis-h"></i></span>');
                            // Prepare query string and send AJAX request
                            jQuery.ajax({
                                url: '/add-hymn-to-user-hinario',
                                data: 'ajax=true&hymn_id=' + escape($form.find('.hymn_id').val()) + '&user_hinario_id=' + escape($form.find('.user_hinario_id').val()),
                                success: function(msg) {
                                    $form.find('.add_hymn_{{ $hymn->id }}_to_{{ $userHinario->id }}_response').html(msg);
                                }
                            });
                        });
                    </script>
                @endforeach

                <div class="help-block text-center">
                @if (count($userHinarios) > 0)
                    {{ __('universal.add_hymn_form.create_header_multiple') }}
                @else
                    {{ __('universal.add_hymn_form.create_header') }}
                @endif
                </div>

                <form class="add_hymn_{{ $hymn->id }}_to_new" role="form" method="POST" action="{{ url('/add-hymn-to-user-hinario') }}" accept-charset="UTF-8" id="add-hymn-{{ $hymn->id }}-to-user-hinario">
                    <div class="form-group">
                            @csrf
                            <label class="sr-only" for="new_hinario_name">{{ __('universal.add_hymn_form.new_hinario_name') }}</label>
                            <input name="new_hinario_name" type="text" class="new_hinario_name add-hymn-text-input" id="new_hinario_name" placeholder="{{ __('universal.add_hymn_form.new_name_placeholder') }}">
                            <input type="hidden" name="hymn_id" value="{{ $hymn->id }}" class="hymn_id">
                            <input type="hidden" name="action" value="create" class="action">
                            <button type="submit" class="btn btn-primary btn-block add-hymn-button">{{ __('universal.add_hymn_form.create_new_hinario') }}</button>
                    </div>
                    <div class="add_hymn_{{ $hymn->id }}_to_new_response add-hymn-response" id="add_hymn_{{ $hymn->id }}_to_new_response"></div>
                </form>

                <script>
                    //Feedback form processing
                    jQuery('.add_hymn_{{ $hymn->id }}_to_new').on('submit', function( e ) {
                        e.preventDefault();
                        var $form = jQuery(this);
                        // update user interface
                        $form.find('.add_hymn_{{ $hymn->id }}_to_new_response').html('<span><i class="fas fa-ellipsis-h"></i></span>');
                        // Prepare query string and send AJAX request
                        jQuery.ajax({
                            url: '/add-hymn-to-user-hinario',
                            data: 'ajax=true&hymn_id=' + escape($form.find('.hymn_id').val()) + '&action=create&new_hinario_name=' + escape($form.find('.new_hinario_name').val()),
                            success: function(msg) {
                                $form.find('.add_hymn_{{ $hymn->id }}_to_new_response').html(msg);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </li>
</ul>
