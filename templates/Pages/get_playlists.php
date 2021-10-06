<?php

require_once '../src/Controller/db_conection.php';

$total = $_GET['LAST_ID'];
if($total < 0){$total = 0;}

echo JsonReturnQuery("select * from playlists limit ".$total.", 10");



?>