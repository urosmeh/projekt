<?php
include "header.php";
include_once "db.php";
include_once "session.php";

$sql = "SELECT * FROM Products";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        $result2 = $conn->query($sql);
        if ($result2->num_rows > 0) {
            while($row2 = $result2->fetch_assoc()) {
                similar_text($row['Title'], $row2['Title'], $perc);
                if($perc>80){
                    //echo "similarity: ($perc %)<br>";
                    $id = $row['ID'];
                    $id2 = $row2['ID'];
                    $query = "INSERT INTO similarproducts(Text, Products_ID, SimilarProduct_ID) VALUES ($perc, $id, $id2)";
                    mysqli_query($conn, $query);
                }
            }
        }

    }
}

header('Location: admin.php');
exit;