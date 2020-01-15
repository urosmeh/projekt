<?php 
include "header.php"; 
include_once "db.php";
?>


    <div class="wrapper row3">

        <main class="hoc container clear">

            <ul class="nospace group center">
                <h6 style="position:center;">Primerjalko</h6>
                <li class="quarter first btmspace-30">
                    <article class="block inspace-30 borderedbox">
                        <h6 class="font-x1">

    <?php
    $id =$_GET['id'];
    //Remove LIMIT 1 to show/do this to all results.
    $sql = 'SELECT * FROM products WHERE ID = '.$id.' LIMIT 1';
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);

    // Echo page content
    echo $row['Title'];

    $id = $row["ID"];
    $idIzbran = $row["ID"];
    $query = mysqli_query($conn, "SELECT * FROM favorites WHERE Products_ID='$id' LIMIT 1");
    
    if (!$query)
    {
        die('Error: ' . mysqli_error($conn));
    }
?>
                            <br><br><br>
                            <?php

    $sqlPicture = "SELECT * FROM Pictures INNER JOIN Products ON products.ID = Pictures.Products_ID WHERE Products_ID=$id ";
    $resultPicture = $conn->query($sqlPicture);


    if ($resultPicture->num_rows > 0) {
        // nedela za slike na samo na favorites
        while($rowPicture = $resultPicture->fetch_assoc()) {
            echo "<img src=". $rowPicture["url"] ." alt=". $rowPicture["Title"] ." height='200' width='200'>";
        }
    }

    echo "<br><br>Najceneje:" . "<h5><b>". $row["Price"]."€</b></h5><br><b>Opis:</b> ".$row['Description']."<br>" ;
                            //realterm
                          //  exec('Realterm.exe baud=57600 port=7 visible=1 tab=Send STRING1="LED_OFF"');
                            //exec('echo '. round($row["Price"]).' > cena.txt');
                            //exec('Realterm.exe baud=57600 port=7 visible=1 tab=Send SENDFILE="C:\wamp64\www\Primerjalko\cena.txt"');
                            exec('echo '. round($row["Price"]).' > COM7');
                            
                            if(isset($_SESSION['ID'])){
        if(mysqli_num_rows($query) > 0){
            echo "<br> Link:<a href=". $row["ProductURL"] .">". $row["Title"]. "</a>  Cena:" . $row["Price"] ." Priljubljen izdelek<br><br>";
        }else{
            echo "<br> Link:<a href=". $row["ProductURL"] .">". $row["Title"]. "</a>  Cena:" . $row["Price"]." <a href='addfavorite.php?id=$id'>Dodaj med priljubljene.</a> <br><br>";
        }
    }else
    {
        echo "<br> Link:<a href=". $row["ProductURL"] .">". $row["Title"]. "</a><br><br> ";
    }
    
       ?>
    </div>


<div class="wrapper row3">
    <main class="hoc container clear">
        <!-- main body -->
        <!-- ################################################################################################ -->
        <ul class="nospace group center">

            <?php
            /* pobrati podatke iz baze ter jih izpisati tukaj v div.
             * vsak izdelek v svojem divu, div poleg diva, 3-4 izdelki v vrsti MAX
             * začnemo z najpopularnejšimi nato vedno manj.
             */

            //LIMIT koliko naj se jih prikaže na strani
            $sql6 = "SELECT * FROM products p INNER JOIN similarproducts s ON s.Products_ID=p.ID WHERE s.Products_ID=$idIzbran ORDER BY HistCmp DESC limit 6";
            $result6 = $conn->query($sql6);

            echo "<h3>Podobni izdelki</h3>";

            if ($result6->num_rows > 0) {
                // output data of each row

                $first = true;
                $ct = 0;
                while ($row6 = $result6->fetch_assoc()) {

                    $ct++;

                    $id6 = $row6["SimilarProduct_ID"];
                    $sqlPicture6 = "SELECT * FROM Pictures WHERE Products_ID=$id6 LIMIT 1";
                    $resultPicture6 = $conn->query($sqlPicture6);
                    $rowPicture6 = $resultPicture6->fetch_assoc();

                    $sqlPrdoduct6 = "SELECT * FROM Products WHERE ID=$id6 LIMIT 1";
                    $resultProduct6 = $conn->query($sqlPrdoduct6);
                    $rowProduct6 = $resultProduct6->fetch_assoc();

                    ?>
                    <div class="one_third <?= $first == true ? "first" : ""; ?> btmspace-30">
                        <div class="block inspace-30 borderedbox">
                            <h6 class="font-x1">
                                <?php
                                echo "<a href='product.php?id=$id6'>".$rowProduct6['Title']."</a><br>"; if(isset($rowPicture6['url'])){echo "<img src=".$rowPicture6['url']." alt=".$rowPicture6['Title']. "height=0 width=0>";} else{echo  "<img src='../Primerjalko/Slike/icon3.png'>";}
                                echo "<br> Cena: " ."<h5><b>". $rowProduct6["Price"]."€</b></h5>" . " </article> </li>";
                            ?>
                            </h6>
                        </div>
                    </div>
                    <?php
                    $first = ($ct % 3 == 0) ? true : false;

                }

            } else {
                echo "Ni podobnih izdelkov";
            }
            ?>
        </ul>
        <!-- ################################################################################################ -->
        <!-- / main body -->
        <div class="clear"></div>
    </main>
</div>


</article> </li>
</ul>

<div class="clear"></div>
</main>

</div>

<?php
include "footer.php";
?>
