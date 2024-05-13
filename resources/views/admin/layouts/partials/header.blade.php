<div class="container">
    <div class="row">
        <div class="col-sm-12 display_table">
            <div class="header_left_logo display_table_cell"> <a href="{{ url('/') }}" class="logo logo_with_text">
                    <img src="/images/nossairmandade_logo.png" alt="">
                    <span class="logo_text">
                        Nossa<br>
                        Irmandade
                    </span>
                </a> </div>
            <div class="header_mainmenu display_table_cell text-right">
                <!-- main nav start -->
                @include ('admin.layouts.partials.nav')
                <!-- header toggler --><span class="toggle_menu"><span></span></span>
            </div>
        </div>
    </div>
</div>
