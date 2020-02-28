<?php
function myLogger($msg,$page,$type)
{
    $t=time();
    $txt = "[ ".date("Y-M-d h:i:sa",$t)." ] "."[ $type ] $page : $msg";
    $myfile = file_put_contents('../logs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
    if($myfile == false)
    {
        die("Application logger failed to execute.");
    }
}
?>
