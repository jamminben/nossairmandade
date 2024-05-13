<footer class="page_footer ds section_padding_top_150 section_padding_bottom_130 columns_margin_bottom_30">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 text-center">
                <div class="logo vertical_logo topmargin_20"> <img src="/images/footer_logo_white.png" alt="Nossa Imandade Logo"> <span class="logo_text">
                        <small>nossairmandade.com</small>
                    </span> </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 text-center text-sm-left">
                <div class="widget widget_text greylinks color2">
                    <h5 class="widget-title"> {{ __('universal.footer.churches') }} </h5>
                    @foreach ($footerChurches as $church)
                        <div class="media small-media">
                            <div class="media-body"><a href="{{ url($church->url) }}" target="_blank">{{ $church->getName() }}</a></div>
                        </div>
                    @endforeach
                    <div class="media small-media">
                        <div class="media-body"><a href="{{ url('/friends') }}" target="_blank">{{ __('universal.footer.more') }}</a></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 text-center text-sm-left">
                <div class="widget widget_text greylinks color2">
                    <h5 class="widget-title"> {{ __('universal.footer.official') }} </h5>
                    @foreach ($footerOfficialSites as $site)
                        <div class="media small-media">
                            <div class="media-body"><a href="{{ url($site->url) }}" target="_blank">{{ $site->getName() }}</a></div>
                        </div>
                    @endforeach
                    <div class="media small-media">
                        <div class="media-body"><a href="{{ url('/friends') }}" target="_blank">{{ __('universal.footer.more') }}</a></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 text-center text-sm-left">
                <div class="widget widget_text greylinks color2">
                    <h5 class="widget-title"> {{ __('universal.footer.donate_title') }} </h5>
                    <p>{!! __('universal.footer.donate_text') !!}</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<section class="ds ms page_copyright section_padding_25">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <p>{!! __('universal.footer.copyright') !!}</p>
            </div>
        </div>
    </div>
</section>
