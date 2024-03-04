<?php

ini_set('display_erreurs','On');
error_reporting(E_ALL);

include 'admin/connect.php';
$sessionUser='';
if (isset($_SESSION['user'])){
    $sessionUser=$_SESSION['user'];
}
include 'connect.php';
$tp1 ='includes/templates/';
$css ='layout/css/';
$js ='layout/js/';
$func = 'includes/functions/';




include $func .'functions.php';

include $tp1 . 'header.php';
//include navbar on all pages  expect the one with no navbar vairable
