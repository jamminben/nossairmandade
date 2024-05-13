<html>
<head>
<style>
    body {
        font:8pt/1.5  arial;
        width: 600px;
        background: #fff; 
        color: rgb(9, 31, 71);
        margin: 0; 
        max-width: 800px; 
        display: inline-block; 
        margin:0 auto;
    }
    a, a:link, a:visited, a:hover { color: #ff0000; }
    table {
        width: 100%;
    }
</style>
</head>
<body>

    <div style="background: #fff; color: rgb(9, 31, 71); min-width: 300px; max-width: 800px; display: inline-block; link: #ff0000; margin:0 auto;">
		<div style="max-width: 1000px; margin: 0 auto">

            @yield('main-content')

        </div>
	</div>
</body>
</html>