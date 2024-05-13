<nav class="mainmenu_wrapper">
    <ul class="mainmenu nav sf-menu">
        <li>
            <a href="{{ url('') }}">@lang('nav.home')</a>
        </li>
        <li>
            <a href="{{ url('about') }}">{{ __('nav.info') }}</a>
            <ul>
                <li>
                    <a href="{{ url('about') }}">{{ __('nav.about') }}</a>
                </li>
                <li>
                    <a href="{{ url('whats-new') }}">{{ __('nav.whats-new') }}</a>
                </li>
                <li>
                    <a href="{{ url('faq') }}">{{ __('nav.faq') }}</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/hinarios/individual') }}">{{ __('nav.hinarios') }}</a>
            <ul>
                <li>
                    <a href="{{ url('/hinarios/individual') }}">{{ __('nav.individual') }}</a>
                </li>
                <li>
                    <a href="{{ url('/hinarios/compilations') }}">{{ __('nav.compilation') }}</a>
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
        <li>
            <a href="{{ url('contact') }}">{{ __('nav.contact') }}</a>
        </li>
        <li>
            <a href="{{ url('donate') }}">{{ __('nav.donate') }}</a>
        </li>
    </ul>
</nav>
<!-- eof main nav -->
