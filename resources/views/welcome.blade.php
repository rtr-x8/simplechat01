<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">

    <meta property="og:type" content="blog">
    <meta property="og:description" content="友達追加して、2020年をカウントダウンしよう！">
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:image"
          content="https://github.com/rtr-x8/simplechat01/blob/feature/init-top-page/resources/img/ogp.png?raw=true">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="ja_JP"/>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@rtr_x8">
    <meta name="twitter:creator" content="@rtr_x8">

    <style>
        body {
            --main-bg-color: #C7261A;
            text-align: center;
            font-family: 'Audiowide', cursive;
            background-image: linear-gradient(135deg, var(--main-bg-color) 0%, var(--main-bg-color) 25%, #ffffff 25%, #ffffff 50%, var(--main-bg-color) 50%, var(--main-bg-color) 75%, #ffffff 75%);
            background-size: 60px 60px;
            background-repeat: repeat;
        }

        .wrapper {
            overflow: hidden;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding-bottom: 80px;
            box-sizing: border-box;
        }

        h1 {
            font-weight: bold;
            font-size: 40px;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        h1 span {
            font-size: 150%;
        }

        .img {
            width: 180px;
        }

        img {
            width: 100%;
            margin-top: 20px;
        }

        @media screen and (min-width: 720px) {
            .wrapper {
                padding-bottom: 20px;
            }

            h1 {
                font-size: 90px;
            }

            .img {
                margin-top: 40px;
            }
        }
    </style>

    <title>{{ config('app.name') }}</title>
</head>
<body class="wrapper">
<h1>Count Down<br><span>2020</span></h1>
<div class="line-it-button" data-lang="ja" data-type="friend" data-lineid="284aezpw" style="display: none;"></div>
<script src="https://www.line-website.com/social-plugins/js/thirdparty/loader.min.js" async="async"
        defer="defer"></script>
<p class="img"><img src="https://qr-official.line.me/sid/L/166gqgsq.png" alt=""></p>
</body>
</html>
