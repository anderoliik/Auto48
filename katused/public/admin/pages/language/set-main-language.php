<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 7.04.2017
 * Time: 10:35
 */

require_once "../../../../include/start.php";

$lang = filter_input(INPUT_POST, 'lang', FILTER_SANITIZE_STRING);

$_SESSION['lang'] = $lang;