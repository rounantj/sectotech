<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();

$checkConnection = function (string $name) {
    $error = null;
    $connected = false;
    try {
        $connection = ConnectionManager::get($name);
        $connected = $connection->connect();
    } catch (Exception $connectionError) {
        $error = $connectionError->getMessage();
        if (method_exists($connectionError, 'getAttributes')) {
            $attributes = $connectionError->getAttributes();
            if (isset($attributes['message'])) {
                $error .= '<br />' . $attributes['message'];
            }
        }
    }

    return compact('connected', 'error');
};

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'home']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header>
        <div class="container text-center">
            <a href="https://cakephp.org/" target="_blank" rel="noopener">
                <img alt="CakePHP" src="https://cakephp.org/v2/img/logos/CakePHP_Logo.svg" width="350" />
            </a>
            <h1>
                Welcome to CakePHP <?= Configure::version() ?> Strawberry (🍓)
            </h1>
        </div>
    </header>
    <main class="main">
        <div style="min-width: 90%;" class="container">
            <div class="content">
                <div class="row">
                    <div class="column">
                        <div class="message default text-center">
                            <small>CRUD basic to manage data of playlists in "SECTOTECA".</small>
                        </div>
                        <!-- <div id="url-rewriting-warning" class="alert url-rewriting">
                            <ul>
                                <li class="bullet problem">
                                    URL rewriting is not properly configured on your server.<br />
                                    1) <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/en/installation.html#url-rewriting">Help me configure it</a><br />
                                    2) <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/en/development/configuration.html#general-configuration">I don't / can't use URL rewriting</a>
                                </li>
                            </ul>
                        </div> -->
                       
                    </div>
                </div>
                <style>
                    .hide{
                        display: none;
                    }
                    .form{
                        max-width: 600px;
                    }
                </style>
                <div class="row">
                    <div class="column">
                    <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button dependente="nav-new" class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">New Playlist</button>
                        <button dependente="nav-update" class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Update Playlist</button>
                        <button dependente="nav-delete" class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Delete Playlist</button>
                        <button dependente="nav-delete2" class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Delete Contents</button>
                        <button dependente="nav-add" class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Add Content</button>
                        <button id="hideAll" style="background-color: silver; color: black" class="btn-light">HIDE ALL</button>
                    </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade hide" id="nav-new" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="form">
                                <label>Title:</label><input class="form-control" id="title" placeholder="Input here a title for a playlist...">
                                <label>Description:</label><input class="form-control" id="description" placeholder="Input here a short description this...">
                                <label>Author:</label><input class="form-control" id="author" placeholder="Input here the author name this...">
                                <button style="float: right;" class="btn btn-success" id="insertPlaylist">SAVE</button>
                            </div>
                    </div>
                    <div class="tab-pane fade hide" id="nav-update" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="form">
                                <label>Select The Playlist ID:</label><input list="playlists_id" id="playlist_id2" class="form-control" placeholder="Choose a playlist id in suspense list">
                                <label>New Title:</label><input class="form-control" id="title2" placeholder="Input here a title for a playlist...">
                                <label>New Description:</label><input class="form-control" id="description2" placeholder="Input here a short description this...">
                                <label>New Author:</label><input class="form-control" id="author2" placeholder="Input here the author name this...">
                                <button style="float: right;" class="btn btn-success" id="updatePlaylist">UPDATE</button>
                            </div>
                    <datalist id="playlists_id"></datalist>
                  
                    </div>
                    <div class="tab-pane fade hide" id="nav-delete" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="form">
                            <label>Select The Playlist ID To Delete:</label><input id="selectedID" list="playlists_id" class="form-control" placeholder="Choose a playlist id in suspense list">
                                <button style="float: right;" id="deletePlaylist" class="btn btn-success">DELETE</button>
                            </div>
                    </div>
                    <div class="tab-pane fade hide" id="nav-delete2" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="form">
                            <label>Select The Content ID To Delete:</label><input id="selectedIDContent" list="contents_id" class="form-control" placeholder="Choose a playlist id in suspense list">
                                <button style="float: right;" id="deleteContent" class="btn btn-success">DELETE</button>
                            </div>
                    </div>
                    <div class="tab-pane fade hide" id="nav-add" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="form">
                                <label>Select The Playlist ID:</label><input list="playlists_id" id="playlist_id" class="form-control" placeholder="Choose a playlist id in suspense list">
                                <label>Content Title:</label><input class="form-control" id="title3" placeholder="Input here a title for a playlist...">
                                <label>Content URL:</label><input class="form-control" id="url" placeholder="Input here a url for this...">
                                <label>Content Author:</label><input class="form-control" id="author3" placeholder="Input here the author name this...">
                                <button style="float: right;" class="btn btn-success"  id="insertContent">ADD CONTENT</button>
                            </div>
                            <datalist id="contents_id"></datalist>
                   
                    </div>
                    </div>
                       
                        
                    </div>
                    
                </div>
                <hr>
                <div class="row">
                    <div class="column">
                        <h4>My Playlists:</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Author</th>
                                <th scope="col">Contents</th>
                                </tr>
                            </thead>
                            <tbody id="playlists">
                                
                            </tbody>
                        </table>
                        <h5 style="text-align: center;"><button id="left" style="float: left"><span ><</span></button> <a style="font-size: 2rem" id="value">1</a> <a style="font-size: 2rem" id="total">de 0</a><button id="right" style="float: right"><span >></span></button></h5>
                        <hr>

                        
                    </div>
                    <div class="column">
                        <h4>Content of Selected Playlist:</h4>
                        <span class="titulo">TITLE OF SELECTED ITEM</span><br>                   
                        <span class="author">ALTHOR OF SELECTED ITEM</span><br>
                        <hr>
                        <h6>Contents:</h6>
                        <hr>
                        <span class="urls">URLS OF SELECTED ITEM</span><hr>
                        <span>PREVIEW:</span>
                        <hr>

                        <iframe style="min-height: 600px;" src="" frameborder="0"></iframe>
                        
                    </div>
                </div>
                <hr>
         
               
           
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    var CONTENTS = [],
    LAST_ID = 1;

$("#left").click(function () {
    if (Number($("#value").html()) - 1 >= 1) {
        LAST_ID = LAST_ID - 10;
        $("#value").html(Number($("#value").html()) - 1);
        updateScreen();
    }
});
$("#right").click(function () {
    if (Number($("#value").html()) + 1 <= Number($("#total").text().replace("de ", ""))) {
        LAST_ID = LAST_ID + 10;
        $("#value").html(Number($("#value").html()) + 1);

        updateScreen();
    }
});

$(".nav-link").click(function () {
    $(".hide").hide();
    $("#" + $(this).attr("dependente")).fadeIn();
});
$("#hideAll").click(function () {
    $(".hide").hide();
});

function updateScreen() {
    $("#playlists_id").html("");
    $("#playlists").html("");
    $.ajax({
        type: "GET",
        url: "/sectoteca/getTotal",
        data: "",
        success: function (data) {
            var dados = JSON.parse(data);
            var qual = 0;
            if (Number(dados[0].total) > Math.floor(Number(dados[0].total))) {
                qual = Math.floor(Number(dados[0].total)) + 1;
            }
            $("#total").html("de " + qual);
        },
        error: function (data) {
            // em caso de erro...
        },
        complete: function () {
            // ao final da requisição...
        },
    });

    $.ajax({
        type: "GET",
        url: "/sectoteca/getPlaylists?LAST_ID=" + LAST_ID,
        data: "",
        success: function (data) {
            console.log(data)
            var dados = JSON.parse(data);

            for (const k in dados) {
                LAST_ID = 0;
                $("#playlists_id").append("<option>" + dados[k].id + "</option>");

                $("#playlists").append(
                    "<tr class='cliqueMe'><td class='id'>" + dados[k].id + "</td><td class='title'>" + dados[k].title + "</td><td class='description'>" + dados[k].description + "</td><td class='author'>" + dados[k].author + "</td><td>"+getContentsOptions(dados[k].id).length+"</td></tr>"
                );
            }
            $(".cliqueMe").css("cursor", "pointer");
            $(".cliqueMe").click(function () {
                var id = $(this).find(".id").text();
                $(".author").html($(this).find(".author").text());
                $(".titulo").html($(this).find(".title").text());

                var result = getContentsOptions(id);
                var html = "";
                for (const j in result) [(html += "<label>" + result[j].title + "</label><p style='cursor: pointer; color: blue' class='mostra'>" + result[j].url + "</p>")];
                $(".urls").html(html);
                $(".mostra").click(function () {
                    $("iframe").attr("src", $(this).text());
                });
            });
        },
        error: function (data) {
            // em caso de erro...
        },
        complete: function () {
            // ao final da requisição...
        },
    });

    $.ajax({
        type: "GET",
        url: "/sectoteca/getContents",
        data: "",
        success: function (data) {
            var dados = JSON.parse(data);

            CONTENTS = dados;

            for (const k in dados) {
                $("#contents_id").append("<option>" + dados[k].id + "</option>");
            }
        },
        error: function (data) {
            // em caso de erro...
        },
        complete: function () {
            // ao final da requisição...
        },
    });
}

$("#deletePlaylist").click(function () {
    $.ajax({
        type: "GET",
        url: "/sectoteca/delete?ID=" + $("#selectedID").val() + "&TABLE=playlists",
        data: "",
        success: function (data) {},
        error: function (data) {
            // em caso de erro...
        },
        complete: function () {
            updateScreen();
        },
    });
});
$("#deleteContent").click(function () {
    $.ajax({
        type: "GET",
        url: "/sectoteca/delete?ID=" + $("#selectedIDContent").val() + "&TABLE=contents",
        data: "",
        success: function (data) {},
        error: function (data) {
            // em caso de erro...
        },
        complete: function () {
            updateScreen();
        },
    });
});
$("#insertPlaylist").click(function () {
    $.ajax({
        type: "GET",
        url: "/sectoteca/insert?AUTHOR=" + $("#author").val() + "&TABLE=playlists&DESCRIPTION=" + $("#description").val() + "&TITLE=" + $("#title").val(),
        data: "",
        success: function (data) {},
        error: function (data) {
            // em caso de erro...
        },
        complete: function () {
            updateScreen();
        },
    });
});
$("#insertContent").click(function () {
    var url = $("#url").val().replace(/\//g, "|");

    $.ajax({
        type: "GET",
        url: "/sectoteca/insert?AUTHOR=" + $("#author3").val() + "&TABLE=contents&URL=" + url + "&TITLE=" + $("#title3").val() + "&ID_PLAYLIST=" + $("#playlist_id").val(),
        data: "",
        success: function (data) {},
        error: function (data) {
            // em caso de erro...
        },
        complete: function () {
            updateScreen();
        },
    });
});
$("#updatePlaylist").click(function () {
    var ID = $("#playlist_id2").val();
    $.ajax({
        type: "GET",
        url: "/sectoteca/update?AUTHOR=" + $("#author2").val() + "&TABLE=playlists&DESCRIPTION=" + $("#description2").val() + "&TITLE=" + $("#title2").val() + "&ID=" + ID,
        data: "",
        success: function (data) {},
        error: function (data) {
            // em caso de erro...
        },
        complete: function () {
            updateScreen();
        },
    });
});
$("#updateContents").click(function () {
    var url = $("#url").val().replace(/\//g, "|");

    var ID = $("#playlist_id").val();
    $.ajax({
        type: "GET",
        url: "/sectoteca/update?AUTHOR=" + $("#author3").val() + "&TABLE=contents&URL=" + url + "&TITLE=" + $("#title3").val() + "&ID_PLAYLIST=" + ID,
        data: "",
        success: function (data) {},
        error: function (data) {
            // em caso de erro...
        },
        complete: function () {
            updateScreen();
        },
    });
});

function getContentsOptions(idPlaylist) {
    var resultados = [];
    for (const k in CONTENTS) {
        if (CONTENTS[k].playlist_id == Number(idPlaylist)) {
            resultados.push(CONTENTS[k]);
        }
    }
    return resultados;
}

updateScreen();

        
    </script>
</body>
</html>
