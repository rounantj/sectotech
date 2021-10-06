<?php

use SebastianBergmann\Environment\Console;

require_once '../src/Controller/db_conection.php';


if($_GET['TABLE'] == "contents"){
    try {
        $url = str_replace("|","/",$_GET['URL']);
        echo "UPDATsE -> ".$url
        voidQuery("update ".$_GET['TABLE']." set playlist_id =  ".$_GET['ID_PLAYLIST'].", title ='".$_GET['TITLE']."', url='".$url.+"', author ='".$_GET['AUTHOR']."' where id = ".$_GET['ID']);
        echo "updated with success";
    }catch (\Throwable $th) {
        echo $th;
    }

}else{
    try {
        voidQuery("update ".$_GET['TABLE']." set title ='".$_GET['TITLE']."', description='".$_GET['DESCRIPTION']."', author ='".$_GET['AUTHOR']."' where id = ".$_GET['ID']);
        echo "updated with success";
    }catch (\Throwable $th) {
        echo $th;
    }

}



?>