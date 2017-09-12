<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 7-6-2017
 * Time: 10:27
 */

require_once('database_Class.php');

$register = new register();
$register->createUser($_POST["Username"], $_POST["Password"], $_POST["Password2"]);
