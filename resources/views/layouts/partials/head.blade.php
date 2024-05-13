<title>@yield('header_title') - nossairmandade.com</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/animations.css">
<link rel="stylesheet" href="/css/fonts.css">
<link rel="stylesheet" href="/css/main09.css" class="color-switcher-link">
<link rel="stylesheet" href="/css/nossa.css" class="color-switcher-link">
@yield('extra_styles')

<!-- <link rel="stylesheet" href="/css/shop.css" class="color-switcher-link"> -->
<!--<script src="/js/vendor/modernizr-2.6.2.min.js"></script> -->
<script src="/js/vendor/modernizr-custom.js"></script>

<script src="https://kit.fontawesome.com/6e60e6921e.js" crossorigin="anonymous"></script>
<!-- <script src="/js/local_fot_awesome.js"></script> -->


<script src="/js/compressed.js"></script>
<script src="/js/main.js"></script>

@yield('panzer')

<!--[if lt IE 9]>
<script src="/js/vendor/html5shiv.min.js"></script>
<script src="/js/vendor/respond.min.js"></script>
<script src="/js/vendor/jquery-1.12.4.min.js"></script>
<![endif]-->

<script>
    $.ajaxSetup({
        cache: false
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<script>
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-33928964-1']);
    _gaq.push(['_setDomainName', 'nossairmandade.com']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
