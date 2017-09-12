<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 17-5-2017
 * Time: 13:28
 */

require_once 'database_Class.php';
$database = new CreateProject();
$database->insert($_POST['ProjectName'], $_POST['ProjectDescription'],$_POST['endDate']);