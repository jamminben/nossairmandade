<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>

    @include('layouts.partials.head')

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
            @include('layouts.partials.page_top')
            <header class="page_header header_white toggler_right">
                @include('layouts.partials.homeheader')
            </header>

            <section class="ls section_padding_top_10 section_padding_bottom_10">
                <div class="container">
                    <div class="row columns_padding_25 columns_margin_bottom_20">
                        <div class="col-xs-12">
                            <!-- Carousels -->
                            <div class="widget widget_slider alignright">
                                <h3 class="widget-title"></h3>
                                <div class="owl-carousel" data-nav="true" data-loop="true" data-autoplay="true" data-items="1" data-responsive-lg="1" data-responsive-md="1" data-responsive-sm="1" data-responsive-xs="1">
                                    @foreach ($carousels as $carousel)
                                    <div class="vertical-item">
                                        <div class="item-media bottommargin_15">
                                            <img src="{{ $carousel->getImageSlug() }}" alt="{{ $carousel->getField('button_text') }}">
                                            <div class="media-links">
                                                <a class="abs-link" title="" href="{{ $carousel->getLinkUrl() }}"></a>
                                            </div>
                                        </div>
                                        <div class="item-content">
                                            <h6 class="bottommargin_0">
                                                <a href="{{ $carousel->getLinkUrl() }}">{{ $carousel->getField('caption') }}</a>
                                            </h6>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <h3>{{ __('home.welcome') }}</h3>
                            <p>{!! __('home.intro') !!}</p>

                            <section id="blog" class="ds parallax page_blog section_padding_top_150 section_padding_bottom_130 columns_margin_bottom_30 columns_padding_25">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-3"> <span class="small-text big highlight">
					Our blog
				</span>
                                            <h2 class="section_header">Latest Plant News</h2>
                                            <div class="widget widget_categories topmargin_50">
                                                <ul class="greylinks">
                                                    <li class=""> <a href="blog-left.html">Products</a> </li>
                                                    <li class=""> <a href="blog-left.html">Plant</a> </li>
                                                    <li class=""> <a href="blog-left.html">News</a> </li>
                                                    <li class=""> <a href="blog-left.html">Dispensary</a> </li>
                                                </ul>
                                            </div>
                                            <p class="topmargin_40"> <a href="blog-left.html" class="theme_button color3">
                                                    Go to Blog
                                                </a> </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="owl-carousel" data-nav="true" data-dots="false" data-responsive-lg="3" data-responsive-md="2" data-responsive-sm="2">
                                                <article class="post vertical-item content-padding rounded overflow_hidden loop-color">
                                                    <div class="item-media entry-thumbnail"> <img src="images/events/08.jpg" alt=""> </div>
                                                    <div class="item-content ls">
                                                        <header class="entry-header">
                                                            <div class="entry-meta content-justify small-text"> <span class="greylinks">
										<a href="blog-single-left.html">
											<time datetime="2017-10-03T08:50:40+00:00">
											15 jan, 2018</time>
										</a>
									</span> <span class="categories-links highlightlinks">
										<a href="blog-left.html">Products</a>
									</span> </div>
                                                            <h4 class="entry-title"> <a href="blog-single-left.html">We Launches New CBD Product</a> </h4>
                                                        </header>
                                                        <div class="entry-content content-3lines-ellipsis">
                                                            <p>Tenderloin pork loin leberkas buffalo, sirloin landjaeger short...</p>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="post vertical-item content-padding rounded overflow_hidden loop-color">
                                                    <div class="item-media entry-thumbnail"> <img src="images/events/03.jpg" alt=""> </div>
                                                    <div class="item-content ls">
                                                        <header class="entry-header">
                                                            <div class="entry-meta content-justify small-text"> <span class="greylinks">
										<a href="blog-single-left.html">
											<time datetime="2017-10-03T08:50:40+00:00">
											23 jan, 2018</time>
										</a>
									</span> <span class="categories-links highlightlinks">
										<a href="blog-left.html">Plant</a>
									</span> </div>
                                                            <h4 class="entry-title"> <a href="blog-single-left.html">Provides Update on 30,000 Sq.</a> </h4>
                                                        </header>
                                                        <div class="entry-content content-3lines-ellipsis">
                                                            <p>Jerky rump venison turk tenderloin beef turduck. Pork loin picanha... </p>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="post vertical-item content-padding rounded overflow_hidden loop-color">
                                                    <div class="item-media entry-thumbnail"> <img src="images/events/10.jpg" alt=""> </div>
                                                    <div class="item-content ls">
                                                        <header class="entry-header">
                                                            <div class="entry-meta content-justify small-text"> <span class="greylinks">
										<a href="blog-single-left.html">
											<time datetime="2017-10-03T08:50:40+00:00">
											31 jan, 2018</time>
										</a>
									</span> <span class="categories-links highlightlinks">
										<a href="blog-left.html">News</a>
									</span> </div>
                                                            <h4 class="entry-title"> <a href="blog-single-left.html">Overview of 2017 Highlights</a> </h4>
                                                        </header>
                                                        <div class="entry-content content-3lines-ellipsis">
                                                            <p>Pork loin picanha hambu prosciutto buffalo, chick kielbasa strip...</p>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="post vertical-item content-padding rounded overflow_hidden loop-color">
                                                    <div class="item-media entry-thumbnail"> <img src="images/events/04.jpg" alt=""> </div>
                                                    <div class="item-content ls">
                                                        <header class="entry-header">
                                                            <div class="entry-meta content-justify small-text"> <span class="greylinks">
										<a href="blog-single-left.html">
											<time datetime="2017-10-03T08:50:40+00:00">
											15 jan, 2018</time>
										</a>
									</span> <span class="categories-links highlightlinks">
										<a href="blog-left.html">Products</a>
									</span> </div>
                                                            <h4 class="entry-title"> <a href="blog-single-left.html">We Launches New CBD Product</a> </h4>
                                                        </header>
                                                        <div class="entry-content content-3lines-ellipsis">
                                                            <p>Tenderloin pork loin leberkas buffalo, sirloin landjaeger short...</p>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="post vertical-item content-padding rounded overflow_hidden loop-color">
                                                    <div class="item-media entry-thumbnail"> <img src="images/events/06.jpg" alt=""> </div>
                                                    <div class="item-content ls">
                                                        <header class="entry-header">
                                                            <div class="entry-meta content-justify small-text"> <span class="greylinks">
										<a href="blog-single-left.html">
											<time datetime="2017-10-03T08:50:40+00:00">
											23 jan, 2018</time>
										</a>
									</span> <span class="categories-links highlightlinks">
										<a href="blog-left.html">Plant</a>
									</span> </div>
                                                            <h4 class="entry-title"> <a href="blog-single-left.html">Provides Update on 30,000 Sq.</a> </h4>
                                                        </header>
                                                        <div class="entry-content content-3lines-ellipsis">
                                                            <p>Jerky rump venison turk tenderloin beef turduck. Pork loin picanha... </p>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="post vertical-item content-padding rounded overflow_hidden loop-color">
                                                    <div class="item-media entry-thumbnail"> <img src="images/events/11.jpg" alt=""> </div>
                                                    <div class="item-content ls">
                                                        <header class="entry-header">
                                                            <div class="entry-meta content-justify small-text"> <span class="greylinks">
										<a href="blog-single-left.html">
											<time datetime="2017-10-03T08:50:40+00:00">
											31 jan, 2018</time>
										</a>
									</span> <span class="categories-links highlightlinks">
										<a href="blog-left.html">News</a>
									</span> </div>
                                                            <h4 class="entry-title"> <a href="blog-single-left.html">Overview of 2017 Highlights</a> </h4>
                                                        </header>
                                                        <div class="entry-content content-3lines-ellipsis">
                                                            <p>Pork loin picanha hambu prosciutto buffalo, chick kielbasa strip...</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </section>

            @include('layouts.partials.footer')
        </div>
    </div>

    @include('layouts.partials.footer_js')

</body>

</html>
