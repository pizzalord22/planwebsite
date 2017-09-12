<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 7-6-2017
 * Time: 13:39
 */

require_once "database_Class.php";
$login = new login();
$login->userLogin($_POST["Username"], $_POST["Password"]);