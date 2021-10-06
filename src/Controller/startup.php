<?php

use PhpParser\Node\Stmt\TryCatch;

require_once '../src/Controller/db_conection.php';

try {
    voidQuery("create table if not exists playlists( id integer not null auto_increment, title varchar(100)  not null, description varchar(100),author varchar(100)  not null, created_at timestamp, updated_at timestamp default now(), primary key(id))");
    voidQuery("create table if not exists contents( id integer not null auto_increment, playlist_id integer not null, title varchar(150) not null, url varchar(255),author varchar(150) not null, created_at timestamp, updated_at timestamp default now(), primary key(id))");
} catch (\Throwable $th) {
    echo $th;
}




?>