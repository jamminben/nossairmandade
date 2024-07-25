<nav class="mainmenu_wrapper">
    <ul class="mainmenu nav sf-menu">
        <li>
            <a href="{{ url('') }}">@lang('nav.home')</a>
        </li>
        <li>
            <a>{{ __('nav.hinarios') }}</a>
            <ul>
                <li>
                    <a href="{{ url('/hinarios/founders') }}">{{ __('nav.founders') }}</a>
                </li>
                <li>
                    <a href="{{ url('/hinarios/iceflu') }}">{{ __('nav.iceflu') }}</a>
                </li>
                <li>
                    <a href="{{ url('/hinarios/cefli') }}">{{ __('nav.cefli') }}</a>
                </li>
                <li>
                    <a href="{{ url('/hinarios/other') }}">{{ __('nav.others') }}</a>
                </li>
                <li>
                    <a href="{{ url('/hinarios/local') }}">{{ __('nav.local') }}</a>
                </li>
                @if (Auth::check())
                <li>
                    <a href="{{ url('/hinarios/personal') }}">{{ __('nav.personal') }}</a>
                </li>
                @endif
            </ul>
        </li>
        @if (\App\Services\GlobalFunctions::getCurrentLanguage() == \App\Enums\Languages::ENGLISH)
        <li> <a href="{{ url('/portuguese/vocabulary') }}">{{ __('nav.portuguese') }}</a>
            <ul>
                <?php /*
                <li>
                    <a href="{{ url('/portuguese/vocabulary') }}">{{ __('nav.vocabulary') }}</a>
                </li>
 */ ?>
                <li>
                    <a href="{{ url('/portuguese/pronunciation') }}">{{ __('nav.pronunciation') }}</a>
                </li>
                <li>
                    <a href="{{ url('/portuguese/for-beginners') }}">{{ __('nav.for_beginners') }}</a>
                </li>

            </ul>
        </li>
        @endif
        <li> <a href="{{ url('/books') }}">{{ __('nav.other') }}</a>
            <ul>
                <li>
                    <a href="{{ url('/books') }}">{{ __('nav.books') }}</a>
                </li>
                <li>
                    <a href="{{ url('/friends') }}">{{ __('nav.links') }}</a>
                </li>
                <li>
                    <a href="{{ url('/musicians') }}">{{ __('nav.musicians') }}</a>
                </li>
            </ul>
        </li>
        <li> <a href="{{ url('/donate') }}">{{ __('nav.donate') }}</a>
            <ul>
                <li>
                    <a href="{{ url('donate') }}">{{ __('nav.donate') }}</a>
                </li>
<!--                <li>
                    <a href="{{ url('subscribe') }}">{{ __('nav.subscribe') }}</a>
                </li> -->
            </ul>
        </li>
        <li>
            <a href="{{ url('contact') }}">{{ __('nav.contact') }}</a>
        </li>
    </ul>
</nav>
<!-- eof main nav -->
