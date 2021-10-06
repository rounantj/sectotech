<?php

require_once '../src/Controller/db_conection.php';

$id = $_GET['ID'];
$table = $_GET['TABLE'];


echo JsonReturnQuery("select * from ".$table." where id = ".$id);



?>