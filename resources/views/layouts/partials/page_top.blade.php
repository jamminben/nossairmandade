<section class="page_topline ls ms table_section table_section_md">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-lg-3 text-left text-sm-left">
                @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->hasRole('superadmin'))
                    <a href="{{route('users.index') }}">admin</a>
                @endif
            </div>
            <div class="col-sm-8 col-lg-12 text-center text-sm-right">
                <div class="inline-content big-spacing">
                    <div class="inline-content">
                        <a href="{{ url('language/EN') }}"><img src="{{ url('images/flags/us.png') }}" alt="{{ __('page_top.language.alt_en') }}" width="24" height="24"></a>
                        <a href="{{ url('language/PT') }}"><img src="{{ url('images/flags/brazil.png') }}" alt="{{ __('page_top.language.alt_pt') }}" width="24" height="24"></a>
                        <!-- <a href="{{ url('language/ES') }}"><img src="{{ url('images/flags/spain.png') }}" alt="{{ __('page_top.language.alt_es') }}" width="24" height="24"></a> -->
                        <!-- <a href="{{ url('language/FR') }}"><img src="{{ url('images/flags/france.png') }}" alt="{{ __('page_top.language.alt_fr') }}" width="24" height="24"></a> -->
                        <!-- <a href="{{ url('language/IT') }}"><img src="{{ url('images/flags/italy.png') }}" alt="{{ __('page_top.language.alt_it') }}" width="24" height="24"></a> -->
                        <!-- <a href="{{ url('language/NL') }}"><img src="{{ url('images/flags/holland.png') }}" alt="{{ __('page_top.language.alt_nl') }}" width="24" height="24"></a> -->
                        <!-- <a href="{{ url('language/JA') }}"><img src="{{ url('images/flags/japan.png') }}" alt="{{ __('page_top.language.alt_ja') }}" width="24" height="24"></a> -->
                    </div>
                    <span class="greylinks">
						<a href="{{ url('search') }}">{{ __('page_top.advanced_search') }}</a>
					</span>
                    <div class="widget widget_search">
                        <span>
                            <form method="get" action="{{ url('search') }}">
                                <div class="form-group"> <label class="sr-only" for="widget-search">{{ __('page_top.search.label') }}:</label> <input id="widget-search" type="text" value="" name="hymn_contains" class="form-control" placeholder="{{ __('page_top.search.placeholder') }}"> </div>
                                <button type="submit" class="theme_button color4 no_bg_button">{{ __('page_top.search.button') }}</button>
                            </form>
                        </span>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            @if (\Illuminate\Support\Facades\Auth::check())
                                @include('layouts.partials.logout_form')
                            @else
                                @include('layouts.partials.login_form')
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
