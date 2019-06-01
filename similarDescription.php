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
                similar_text($row['Description'], $row2['Description'], $perc);
                if($perc>90&&$row['ID']!=$row2['ID']){
                    //echo "similarity: ($perc %)<br>";
                    $id = $row['ID'];
                    $id2 = $row2['ID'];

                    $query = "SELECT * from similarproducts where Products_ID=$id AND SimilarProduct_ID=$id2";
                    $resultObstaja = $conn->query($query);
                    if($resultObstaja->num_rows > 0)
                    {
                        $query = "UPDATE similarproducts SET Description=$perc WHERE Products_ID=$id AND SimilarProduct_ID=$id2";
                        mysqli_query($conn, $query);
                    }
                    else
                    {
                        $query = "INSERT INTO similarproducts(Description, Products_ID, SimilarProduct_ID) VALUES ($perc, $id, $id2)";
                        mysqli_query($conn, $query);
                    }
                }
            }
        }

    }
}

header('Location: admin.php');
exit;