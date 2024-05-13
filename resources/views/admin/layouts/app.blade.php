<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>

    @include('layouts.partials.head')
    @yield('css')

</head>

<body>
    <!--[if lt IE 9]>
    <div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your experience.</div>
    <![endif]-->
    <div class="preloader">
        <div class="preloader_image"></div>
    </div>
    <!-- search modal -->
    <div class="modal" tabindex="-1" role="dialog" aria-labelledby="search_modal" id="search_modal"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">
                <i class="rt-icon2-cross2"></i>
            </span>
        </button>
        <div class="widget widget_search">
            <form method="get" class="searchform search-form form-inline" action="./">
                <div class="form-group bottommargin_0"> <input type="text" value="" name="search" class="form-control" placeholder="Search keyword" id="modal-search-input"> </div> <button type="submit" class="theme_button no_bg_button">Search</button> </form>
        </div>
    </div>
    <!-- Unyson messages modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="messages_modal">
        <div class="fw-messages-wrap ls with_padding">
            <!-- Uncomment this UL with LI to show messages in modal popup to your user: -->
            <!--
        <ul class="list-unstyled">
            <li>Message To User</li>
        </ul>
        -->
        </div>
    </div>

    <!-- wrappers for visual page editor and boxed version of template -->
    <div id="canvas" class="boxed ni_bg">
        <div id="box_wrapper" class="container top-bottom-margins">
            <header class="page_header header_white toggler_right">
                @include('admin.layouts.partials.header')
            </header>
            <section class="page_breadcrumbs ds parallax section_padding_top_0 section_padding_bottom_0">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-12 text-center text-md-left display_table_md">
                            @yield('page_title')
                        </div>
                    </div>
                </div>
            </section>

            <section class="ls section_padding_bottom_130 columns_padding_30 section_margin_top_40">
                <div class="container">
                    <div class="row">
                        <!-- <div class="col-sm-1"></div> -->
                        @yield('content')
                        <!-- <div class="col-sm-1"></div> -->
                    </div>
                </div>
            </section>

            @include('layouts.partials.footer')
        </div>
    </div>
    @include('layouts.partials.footer_js')
    @yield('js');

</body>

</html>
