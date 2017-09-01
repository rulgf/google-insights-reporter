<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Dood Analytics</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    <link type="text/css" rel="stylesheet" href="css/theme-default/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="css/theme-default/materialadmin.css" />
    <link type="text/css" rel="stylesheet" href="css/theme-default/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="css/theme-default/material-design-iconic-font.min.css" />
    <link type="text/css" rel="stylesheet" href="css/theme-default/libs/rickshaw/rickshaw.css" />
    <link type="text/css" rel="stylesheet" href="css/theme-default/libs/morris/morris.core.css" />
    <link type="text/css" rel="stylesheet" href="css/theme-default/libs/select2/select2.css" />
    <link type="text/css" rel="stylesheet" href="css/theme-default/libs/multi-select/multi-select.css" />
    <link type="text/css" rel="stylesheet" href="css/react-selectize/index.css" />
    <link type="text/css" rel="stylesheet" href="css/custom.css" />
    <link type="text/css" rel="stylesheet" href="css/react-data-grid/react-data-grid.css" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset("img/favicon/apple-icon-57x57.png")}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset("img/favicon/apple-icon-60x60.png")}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset("img/favicon/apple-icon-72x72.png")}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset("img/favicon/apple-icon-76x76.png")}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset("img/favicon/apple-icon-114x114.png")}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset("img/favicon/apple-icon-120x120.png")}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset("img/favicon/apple-icon-144x144.png")}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset("img/favicon/apple-icon-152x152.png")}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset("img/favicon/apple-icon-180x180.png")}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset("img/favicon/android-icon-192x192.png")}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset("img/favicon/favicon-32x32.png")}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset("img/favicon/favicon-96x96.png")}}">
</head>



<body class="menubar-hoverable header-fixed full-content">

<div class="container" id="app"></div>


<!-- Los scripts de build hasta abajo sino no renderean -->

<script src="js/bundle.js"></script>

<!-- BEGIN JAVASCRIPT -->
<script src="js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script src="js/libs/bootstrap/bootstrap.min.js"></script>
<script src="js/libs/spin.js/spin.min.js"></script>
<script src="js/libs/autosize/jquery.autosize.min.js"></script>
<script src="js/libs/moment/moment.min.js"></script>
<script src="js/libs/flot/jquery.flot.min.js"></script>
<script src="js/libs/flot/jquery.flot.time.min.js"></script>
<script src="js/libs/flot/jquery.flot.resize.min.js"></script>
<script src="js/libs/flot/jquery.flot.orderBars.js"></script>
<script src="js/libs/flot/jquery.flot.pie.js"></script>
<script src="js/libs/flot/curvedLines.js"></script>
<script src="js/libs/jquery-knob/jquery.knob.min.js"></script>
<script src="js/libs/sparkline/jquery.sparkline.min.js"></script>
<script src="js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
<script src="js/libs/d3/d3.min.js"></script>
<script src="js/libs/d3/d3.v3.js"></script>
<script src="js/libs/rickshaw/rickshaw.min.js"></script>
<script src="js/core/source/App.js"></script>
<script src="js/core/source/AppNavigation.js"></script>
<script src="js/core/source/AppOffcanvas.js"></script>
<script src="js/core/source/AppCard.js"></script>
<script src="js/core/source/AppForm.js"></script>
<script src="js/core/source/AppNavSearch.js"></script>
<script src="js/core/source/AppVendor.js"></script>
<script src="js/core/demo/Demo.js"></script>
<script src="js/core/demo/DemoDashboard.js"></script>
<script src="js/custom.js"></script>


<!-- END JAVASCRIPT -->

</body>

</html>