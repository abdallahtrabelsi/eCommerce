<?php
include 'connect.php';
$tp1 ='includes/templates/';
$css ='layout/css/';
$js ='layout/js/';
$func = 'includes/functions/';
$lang ='includes/languages/';


 include $func .'functions.php';
 include $tp1 . 'header.php';

if (!isset($noNavbar)){
 

include $tp1 .'navbar.php';
}
