<?php



require_once '../src/Controller/db_conection.php';

if($_GET['TABLE'] == "contents"){

    try {
      
        $url = str_replace("|","/",$_GET['URL']);
        echo "DEPOIS-> ".$url;
        voidQuery("insert into ".$_GET['TABLE']." values (null, ".$_GET['ID_PLAYLIST'].", '".$_GET['TITLE']."', '".$url."','".$_GET['AUTHOR']."',null,null)");
        echo "saved with success";
    }catch (\Throwable $th) {
        echo $th;
    }

}else{
    try {
        voidQuery("insert into ".$_GET['TABLE']." values (null, '".$_GET['TITLE']."', '".$_GET['DESCRIPTION']."', '".$_GET['AUTHOR']."',null,null)");
        echo "saved with success";
    }catch (\Throwable $th) {
        echo $th;
    }

}




?>