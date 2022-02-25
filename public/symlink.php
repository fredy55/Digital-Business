<?php 
    $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/psalmapp/storage/app/public';
    $linkFolder = 'storage';
    
    if(symlink($targetFolder,$linkFolder)){
        echo 'Symlink process successfully completed';
        echo '<br />'.$targetFolder;
        echo '<br />'.$linkFolder;

    }else{
        echo 'Symlink process FAILED';
    }
    