<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 30-5-2017
 * Time: 11:26
 */


require_once 'database_Class.php';
$database = new createTask();
$database->insert($_POST['projectID'],$_POST['taskName'],$_POST['taskDescription'],$_POST['startDate'],$_POST['endDate']);