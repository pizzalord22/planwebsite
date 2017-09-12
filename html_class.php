<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 17-5-2017
 * Time: 13:24
 */

class Html{
    function getFile($file){
        require_once '../html/'.$file.'.html';
    }
}