<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
{{--   <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>--}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="shopify-domain" content="{{request()->get('shop')}}">
    <title>Shopify Demo app</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!--end::Page Vendors Styles -->
    <link rel="shortcut icon" href="/favicon.ico"/>

    <link rel="stylesheet" href="{{asset(mix('/css/app.css'), true)}}">
    <script>
        SHOP_DOMAIN = "{{request()->user()->name}}"
    </script>
</head>
<body>

<div id="app">

    <router-view> </router-view>
</div>

<script src="{{asset(mix('/js/app.js'), true)}}"></script>


</body>

</html>
