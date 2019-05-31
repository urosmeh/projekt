<?php
include "header.php";
include_once "db.php";
include_once "session.php";

$sql = "SELECT * FROM Products";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $result2 = $conn->query("SELECT  ID, Title FROM products WHERE products.ID =".$row['ID']);
        similar_text('ASUS S530FN-BQ083T i7-8565U/8G/256G/MX150/W10/sbm', $row['Title'], $perc);
        if($perc>50){
            echo "similarity: ($perc %)<br>";
            $id = $row['ID'];
            $query = "INSERT INTO similarproducts(Text, Products_ID, SimilarProduct_ID) VALUES ($perc, 1, $id)";
            mysqli_query($conn, $query);
        }

    }
}

header('Location: admin.php');
exit;