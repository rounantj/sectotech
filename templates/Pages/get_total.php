<?php

require_once '../src/Controller/db_conection.php';


echo JsonReturnQuery("select count(*) / 10 as total from playlists ");



?>