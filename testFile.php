<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 17-5-2017
 * Time: 13:25
 */
require_once 'html_class.php';
require_once 'database_Class.php';

if(isset($_GET['page'])){
    $page = $_GET['page'];
    $html = new Html();
    $html->getFile($page);
}else{
    header("location: ../index.php");
}