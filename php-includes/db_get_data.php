<?php

include "db_connect.php";

$type = $_GET['type'];

if($type != null || $type == '') {
    $sql="SELECT * FROM contents_ctrl WHERE content_type = '".$type."'";

    $types_result = mysqli_query($conn,$sql);
    echo "<form method='GET' action='php-includes/db_delete_data.php'>";
    echo "<table class='table'>
    <thead>
    <tr>
    <th>id</th>
    <th>Content type</th>
    <th>Content name</th>
    <th>Content data</th>
    <th></th>
    <th></th>
    </tr>
    </thead>
    <tbody>";
    while($row = mysqli_fetch_assoc($types_result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['content_type'] . "</td>";
        echo "<td>" . $row['content_name'] . "</td>";
        echo "<td><p class='truncate'>" . $row['content_data'] . "</p></td>";
        echo "<td><a href='admin-panel.php?modified=" . $row['id'] . "' class='btn btn-primary'>Modifier</button></td>";
        echo "<td><a href='admin-panel.php?deleted=" . $row['id'] . "'' class='btn btn-danger'>Supprimer</button></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
    echo "</form>";

    mysqli_close($conn);
}


