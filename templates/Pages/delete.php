<?php


require_once '../src/Controller/db_conection.php';


try {
    voidQuery("delete from ".$_GET['TABLE']." where id = ".$_GET['ID']);
    echo $_GET['ID']." deleted with success";
}catch (\Throwable $th) {
    echo $th;
}





?>