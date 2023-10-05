<?php

use App\Models\District;
use App\Models\Village;
use App\Models\Tps;
use App\Models\SaksiData;
use App\Models\Paslon;
?>
<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Zanex – Bootstrap  Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin, dashboard, dashboard ui, admin dashboard template, admin panel dashboard, admin panel html, admin panel html template, admin panel template, admin ui templates, administrative templates, best admin dashboard, best admin templates, bootstrap 4 admin template, bootstrap admin dashboard, bootstrap admin panel, html css admin templates, html5 admin template, premium bootstrap templates, responsive admin template, template admin bootstrap 4, themeforest html">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/brand/favicon.ico" />

    <!-- TITLE -->
    <title>PILPRES - {{$data_prov->name}}</title>

    <!-- BOOTSTRAP CSS -->
    <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="../../assets/css/style.css" rel="stylesheet" />
    <link href="../../assets/css/dark-style.css" rel="stylesheet" />
    <link href="../../assets/css/skin-modes.css" rel="stylesheet" />

    <!-- SIDE-MENU CSS -->
    <link href="../../assets/css/sidemenu.css" rel="stylesheet" id="sidemenu-theme">

    <!--C3 CHARTS CSS -->
    <link href="../../assets/plugins/charts-c3/c3-chart.css" rel="stylesheet" />

    <!-- SELECT2 CSS -->
    <link href="../../assets/plugins/select2/select2.min.css" rel="stylesheet" />

    <!-- DATA TABLE CSS -->
    <link href="../../assets/plugins/datatable/css/dataTables.bootstrap5.css" rel="stylesheet" />
    <link href="../../assets/plugins/datatable/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="../../assets/plugins/datatable/responsive.bootstrap5.css" rel="stylesheet" />

    <!-- INTERNAL SELECT2 CSS -->
    <link href="../../assets/plugins/select2/select2.min.css" rel="stylesheet" />

    <!-- P-scroll bar css-->
    <link href="../../assets/plugins/p-scroll/perfect-scrollbar.css" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="../../assets/css/icons.css" rel="stylesheet" />

    <!-- SIDEBAR CSS -->
    <link href="../../assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="../../assets/colors/color1.css" />

    <link href="../../assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet" />


    <style>
        .tooltip {
            visibility: visible;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 150%;
            left: 50%;
            margin-left: -60px;
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: black transparent transparent transparent;
        }
    </style>

</head>

<body class="app sidebar-mini">

    <a class="nav-link icon theme-layout nav-link-bg layout-setting align-item">
        <span class="dark-layout"><i class="fe fe-moon"></i></span>
        <span class="light-layout"><i class="fe fe-sun"></i></span>
    </a>

    <div class="container" style="margin-top: -60px;">
        <div class="row mt-5">
            <div class="col-md text-center mt-5 ">
                <h4 class="text-uppercase fw-bold">
                    <img style="width: 100px;" src="{{url('')}}/assets/images/brand/logo-2.png" alt="">
                </h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md text-center">
                <h4 style="margin-bottom: 7.5px !important;" class="text-uppercase fw-bold">
                    Pilpres
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center">
                <h4 style="margin-bottom: 7.5px !important;" class="text-uppercase fw-bold">
                    Provinsi {{$data_prov->name}}
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center">
                <h4 class="text-uppercase fw-bold">
                    Tahun 2024
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center">
                <h6 class="text-uppercase fw-bold">
                    {{$title}}
                    </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center">
                <hr>
                <h2 class="text-uppercase fw-bold">
                    Hasil Perhitungan Suara
                </h2>
            </div>
        </div>

        <div class="row mt-1">