<?php
/**
 * Created by PhpStorm.
 * User: janek.mander
 * Date: 10.05.2016
 * Time: 9:04
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="<?php echo TEMPLATE_URL_CSS; ?>bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo TEMPLATE_URL; ?>plugins/chosen/chosen.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL; ?>plugins/sweetalert/dist/sweetalert.css">
    <link href="<?php echo TEMPLATE_URL; ?>plugins/flag-icon/css/flag-icon.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        #grid[data-columns]::before {
            content: '3 .column.size-1of3';
        }

        /* These are the classes that are going to be applied: */
        .column { float: left; margin: 10px; }
        .size-1of3 { width: 31%; }
    </style>
</head>
<body>
<div class="row">
    <div class="col-lg-12"></div>
</div>
