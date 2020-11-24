<?php

$content_type = "";
$content_name = "";
$content_data = "";
$content_id = "";

if (isset($_GET['modified']) && $conn ) {
    $id = $_GET['modified'];
    $sqlModify='SELECT * FROM contents_ctrl WHERE id = "'.$id.'"';
    $result = mysqli_query($conn,$sqlModify);
    $rows = array();
    while($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    echo "<p id='json-text' style='display:none;'>" . json_encode($rows) . "</p>";
}

if (isset($_POST['content_type'])) { $content_type = $_POST['content_type']; }
if (isset($_POST['content_name'])) { $content_name = $_POST['content_name']; }
if (isset($_POST['content_data'])) { $content_data = $_POST['content_data']; }
if (isset($_POST['content_id'])) { $content_id = $_POST['content_id']; }

if ($content_type != "" && $content_name != "" && $content_data != "" && $content_id == "") {
    
    $sql = "INSERT INTO contents_ctrl (content_type, content_name, content_data) VALUES ('$content_type', '$content_name', '$content_data')";

    if (mysqli_query($conn, $sql)) {
    echo "<p>Nouvelle entrée créee<p>";
    } else {
    echo "<p>Error: " . $sql . "<br>" . mysqli_error($conn). "</p>";
    }

    // On remet les champs à vide
    $content_type = "";
    $content_name = "";
    $content_data = "";

} elseif($content_type != "" && $content_name != "" && $content_data != "" && $content_id != "") {

    $sql = "UPDATE contents_ctrl SET content_type = '$content_type', content_name = '$content_name', content_data = '$content_data' WHERE id = '$content_id'";

    if (mysqli_query($conn, $sql)) {
    echo "<p>Données misent à jour<p>";
    } else {
    echo "<p>Error: " . $sql . "<br>" . mysqli_error($conn). "</p>";
    }

    mysqli_close($conn);

    // On remet les champs à vide
    $content_type = "";
    $content_name = "";
    $content_data = "";
    $content_id = "";

} else {
    //echo "<p style='color:white;'>Veuillez remplir tous les champs !<p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['postdata'] = $_POST;
    unset($_POST);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}