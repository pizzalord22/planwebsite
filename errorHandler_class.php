<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 14-3-2017
 * Time: 13:17
 */

class errorHandler{
    function __construct()
    {
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);

        function errorHandler($slevel, $smessage, $sfile, $srow){
            $aLevels = [
                2 => 'WARNING',
                8 => 'NOTICE',
                256 => 'FATAL ERROR',
                512 => 'WARNING',
                1024 => 'NOTICE'
            ];

            if(array_key_exists($slevel, $aLevels)){
                $level = $aLevels[$slevel];
            }else{
                $level = 'UNKNOWN ERROR';
            }

            echo 'An error has occurred <br />';
            echo 'Error type: <span style="color:red;">' . $level . '</span><br />';
            echo 'Error message: <span style="color:blue;">'. $smessage . '</span><br />';
            echo 'File: <span style="color:#009a00;">' . $sfile . '</span><br />';
            echo 'Row: <span style="color:#dd8e07;text-decoration: underline;">' . $srow . '</span><br />';
            echo '-------------------------------------------------------------- <br /> <br />';

            if($slevel == 256){
                echo 'The script has been stopped <br />';
                echo '-------------------------------------------------------------- <br /> <br />';
                exit();
            }
        }
        set_error_handler('errorHandler');
    }
}