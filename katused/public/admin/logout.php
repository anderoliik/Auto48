<?php
/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 21.02.2017
 * Time: 11:21
 */

require_once "../../include/start.php";

$session->logout();
reDirectTo('login.php');