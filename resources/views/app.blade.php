<!DOCTYPE html>
<html lang="en">
<head>
    <title>Jom Fikir Tuition Management System</title>
    <link href="{{mix("/css/crater.css")}}" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="57x57" href="/img/jomfikir-favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/jomfikir-favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/jomfikir-favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/jomfikir-favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/jomfikir-favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/jomfikir-favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/jomfikir-favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/jomfikir-favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/jomfikir-favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/img/jomfikir-favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/jomfikir-favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/jomfikir-favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/jomfikir-favicons/favicon-16x16.png">
    <link rel="manifest" href="/img/jomfikir-favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/img/jomfikir-favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="layout-default skin-crater">
<div id="app" class="template-container">
    <div class="mobile-menu-overlay" @click.prevent="onOverlayClick"></div>
    <transition name="fade" mode="out-in">
        <router-view></router-view>
    </transition>
</div>
<script type="text/javascript" src="{{mix('/js/app.js')}}"></script>
</body>
</html>
