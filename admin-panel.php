<!DOCTYPE html>
<html lang="fr">

<?php
    include "php-includes/db_connect.php";
    include "php-includes/db_insert.php";
    include "php-includes/db_delete_data.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau d'administration - CTRL</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/theme/darcula.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/theme/monokai.min.css">
    <link href="css/admin-panel.css" type="text/css" rel="stylesheet">
</head>

<body>

    <nav id="nav-menu">
        <div>
            <a href="#gallery-row" id="gallery-btn" class="btn section-btn">GALLERIE</a>
            <a href="#css-section" onclick="openCm()" id="file-btn" class="btn section-btn">FICHIERS</a>
            <button id="arrow-menu" class="btn">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5A.5.5 0 0 0 4 8z"/>
                </svg>
            </button>
        </div>
    </nav>

    <section id="content-section">
        <div class="row">
            <h1 class="title">TABLEAU DE BORD</h1>

            <div class="col-md-6 p-5">
                
                <diV class="content_header">
                    <h2>SAUVEGARDE EN BDD</h2>
                </diV>
                <form id="save-form" method="POST" action="admin-panel.php">

                    <!-- Champ de l'id pour la mise à jour -->
                    <input type="hidden" name="content_id" id="content_id">

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" name="content_type">
                            <option>titre_1</option>
                            <option>titre_2</option>
                            <option>titre_3</option>
                            <option>titre_4</option>
                            <option>titre_5</option>
                            <option>paragraphe</option>
                            <option>image</option>
                        </select>
                        <div class="form-text">Type de contenu</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom du contenu</label>
                        <input type="text" class="form-control" name="content_name" id="name" required="required">
                        <div class="form-text">Nom du contenu en base</div>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu</label>
                        <textarea class="form-control" id="content" type="text" name="content_data" rows="10" required="required"></textarea>
                        <div class="form-text">Contenu enregistré en base</div>
                    </div>

                    <button type="submit" onsubmit="submitForm()" class="btn">Envoyer les données</button>
                </form>
            </div>
            <div class="col-md-6 p-5">

                <diV class="content_header">
                    <h2>GESTION DU CONTENU</h2>
                </diV>

                <form method="GET" action="php-includes/db_get_types.php">
                    <select class="form-select" name="data_type" onchange="get_data_types(this.value)">
                        <option selected="selected">Sélectionner le type de contenu</option>
                        <?php
                            // On récupère tous les type de données en base
                            $selectSql = "SELECT DISTINCT content_type FROM contents_ctrl";
                            $result = mysqli_query($conn, $selectSql);
                            if (mysqli_num_rows($result) > 0) {
                                // On affiche les types dans le select
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<option>" . $row["content_type"] . "</option>";
                                }
                            }

                            include "php-includes/db_get_data.php";

                        ?>
                    </select>
                    <div class="form-text">Choisissez le type de contenu</div>
                </form>

                <div id="content_types"></div>
            </div>
        </div>
    </section>

    <!-- Gallery image -->

    <section id="image-gallery">
        <div id="gallery-row">
            <div class="row">
                <h2 class="gallery-title">GALLERIE</h2>
                <?php
                    include "php-includes/db_connect.php";
                            
                    $sql_images = "SELECT * FROM contents_ctrl WHERE content_type = 'image'";
                    $img_result = mysqli_query($conn, $sql_images);
                    
                    if (mysqli_num_rows($img_result) > 0) {
                        // On affiche les types dans le select
                        while($row = mysqli_fetch_assoc($img_result)) {
                            echo "<div class='col-md-3'><div class='img-gallery-container'>";
                            echo "<img loading='lazy' class='img-gallery' src='" . $row['content_data'] . "'/>";
                            echo "<div><a href='php-includes/db_delete_data.php?deleted=" . $row['id'] . "' class='btn'>Supprimer</a></div>";
                            echo "</div></div>";
                        }
                    }
                ?>
            </div>
        </div>
    </section>

	<!-- Modifications CSS -->

    <section id="css-section">
        <div id="file-row">
            <div id="menu-modification">
                <button id="frame-btn" class="btn section-btn">SITE FRAME</button>
                <button id="toggle-css" class="btn section-btn">CSS</button>
                <button id="toggle-php" class="btn section-btn">PHP</button>
            </div>

            <div class="row">
                <div class="col-md-12" id="frame-row">
                    <button id="btn-resize-phone" class="btn">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-phone-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V2zm6 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                    </button>
                    <button id="btn-resize-frame" class="btn">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-aspect-ratio" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M0 3.5A1.5 1.5 0 0 1 1.5 2h13A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5v-9zM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                            <path fill-rule="evenodd" d="M2 4.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H3v2.5a.5.5 0 0 1-1 0v-3zm12 7a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H13V8.5a.5.5 0 0 1 1 0v3z"/>
                        </svg>
                    </button>
                    <button id="refresh-btn" class="btn">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-counterclockwise" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                        </svg>
                    </button>
                    <iframe id="site-frame" src="index.php"></iframe>
                </div>
                <div id="css-col" class="col-md-6 code-col">
                    <button id="btn-resize-css" class="btn btn-code">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-aspect-ratio" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M0 3.5A1.5 1.5 0 0 1 1.5 2h13A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5v-9zM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                            <path fill-rule="evenodd" d="M2 4.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H3v2.5a.5.5 0 0 1-1 0v-3zm12 7a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H13V8.5a.5.5 0 0 1 1 0v3z"/>
                        </svg>
                    </button>

                    <form action="admin-panel.php" method="GET">
                        <div class="mb-3">
                            <textarea id="css-editor" name="css_data"><?php echo file_get_contents('css/style.css');?></textarea>
                            <div class="form-text">Contenu du fichier CSS</div>
                        </div>
                        <button id="css-btn" type="submit" class="btn">Envoyer les données</button>
                    </form>

                    <?php
                        if(isset($_GET['css_data'])) {
                            $css_data = stripslashes($_GET['css_data']);
                            $css = "css/style.css";
                            $css_file = fopen($css, 'w+');
                            fwrite($css_file, $css_data);
                            fclose($css_file);
                        }
                    ?>

                </div>
                <div id="php-col" class="col-md-6 code-col">
                    <button id="btn-resize-php" class="btn btn-code">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-aspect-ratio" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M0 3.5A1.5 1.5 0 0 1 1.5 2h13A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5v-9zM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                            <path fill-rule="evenodd" d="M2 4.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H3v2.5a.5.5 0 0 1-1 0v-3zm12 7a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H13V8.5a.5.5 0 0 1 1 0v3z"/>
                        </svg>
                    </button>

                    <form action="admin-panel.php" method="GET">
                        <div class="mb-3">
                            <textarea id="php-editor" name="php_data"><?php echo file_get_contents('index.php');?></textarea>
                            <div class="form-text">Contenu du fichier PHP</div>
                        </div>
                            <button type="submit" id="php-btn" class="btn">Envoyer les données</button>
                    </form>

                    <?php
                        if(isset($_GET['php_data'])) {
                            $content = stripslashes($_GET['php_data']);
                            $file = "index.php";
                            $Saved_File = fopen($file, 'w+');
                            fwrite($Saved_File, $content);
                            fclose($Saved_File);
                        }
                    ?>

                </div>
            </div>
        </div>
    </section>

    <div id="footer">
        <p>CTRL - 2020</p>
    </div>

    <!-- VUE JS - Version développement. Celle-ci donne des avertissements utiles sur la console -->
	<!-- <script src="https://unpkg.com/vue@next"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/codemirror.min.js"></script>
    <!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/meta.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/mode/loadmode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/mode/simple.min.js"></script>
    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/clike/clike.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/display/autorefresh.min.js"></script>
    
    <script src="js/app.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
</body>

</html>