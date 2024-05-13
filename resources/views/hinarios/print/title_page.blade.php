<html>
<head>
    <style type="text/css">
        body {font-family: Verdana; letter-spacing: 0; line-height: 1.3em; font-size: 1em;}
        img {display: block; margin: 5px auto; text-align:center;}
        hr { width: 60%; text-align: center; height: 2px; color: black; line-height: .1em; position: relative; top: -30px;}
        h1 { line-height:1.6em; }
        h1,h2,h3 {page-break-after:avoid; text-align:center;}
        .large {font-size:200%; font-weight:bold;}
        .medium {font-size:130%;}
        .center {text-align:center;}
        p { line-height: .1em; }

        .sun-moon-stars {
            padding-top: 20px;
            color: black;
        }

        .hymnstanza {
            overflow: hidden;
        }

        .hymn-notation {
            font-style: italic;
            float: right;
            font-weight: bold;
            padding-left: 3.5in;
            margin: 0px;
        }

        .hymn-words {
            float: left;
            margin-left: 4px;
            color: black;
        }

        .hymn-title {
            float: left;
            margin-left: 4px;
            margin-bottom: 15px;
            color: black;
        }

        .hymn-bar-full {
            float: left;
            padding-left: 4px;
            border-left: 2px solid black;
        }

        .hymn-bar-full {
            float: left;
            padding-left: 4px;
            border-left: 2px solid black;
            width: 100%;
        }

        .hymn-bar-empty {
            float: left;
            padding-left: 4px;
            border-left: 2px solid white;
            width: 100%;
        }

        .hymn-spacer {
            line-height: 3px;
            width: 100%;
            padding-left: 200px;
        }
    </style>
</head>
<body>
<br><br>
<p class='center large' style="line-height: 2em;">{!! str_replace('-', "<br>", $hinario->getName($hinario->original_language_id)) !!}</p>
@if (!empty($hinario->receivedBy))
    <p class='center medium'>{{ $hinario->receivedBy->name }}</p>
@endif
@if (!empty($hinario->image_path))
    <div class="center">
        <img src="{{ url($hinario->image_path) }}" width="80%" max-height="80%">
    </div>
@elseif (get_class($hinario) == \App\Models\Hinario::class && $hinario->type_id == 1)
    <div class="center">
        <img src="{{ url($hinario->receivedBy->getPortrait()) }}" width="80%" max-height="80%">
    </div>
@endif

<pagebreak resetpagenum="1" suppress="off" />
