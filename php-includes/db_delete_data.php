<?php

include "db_connect.php";

if (isset($_GET['deleted']) && $conn ) {
    $id = $_GET['deleted'];
    $sqlDelete='DELETE FROM contents_ctrl WHERE id = "'.$id.'"';
    mysqli_query($conn,$sqlDelete);
    header("Location: http://localhost/site/admin-panel.php");
    mysqli_close($conn);
}
