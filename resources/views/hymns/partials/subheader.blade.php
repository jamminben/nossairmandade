<div class="container">
    <div class="column one">
        <h1 class="title">@yield('page_title')</h1>
        <!--BreadCrumbs area-->
        <ul class="breadcrumbs">
            <li>
                <a href="/">Home</a><span><i class="icon-right-open"></i></span>
            </li>
            <li>
                <a href="/hinario/{{ $activeHinarioId }}">{{ $activeHinarioName }}</a><span><i class="icon-right-open"></i></span>
            </li>
            <li>
                @yield('page_title')
            </li>
        </ul>
    </div>
</div>