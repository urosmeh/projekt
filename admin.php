<?php 
include "header.php"; 
include_once "db.php"; 
include_once "session.php";
?>
<?php

if(isset($_SESSION['Name']) && isset($_SESSION['Surname'])&& $_SESSION['Admin']==1) {
    echo "<table border='1'>";
    echo "<tr>";

    echo "<td><a href='scraper_bigbang.php'> BigBang Scraper </a></td>";
    echo "<td><a href='mlacom.php'> Mlacom Scraper </a></td>";
    echo "<td><a href='markosoftscrap.php'> Markosoft Scraper </a></td>";
    echo "<td><a href='markosoftscrap.php'> Primerjalko Scraper </a></td>";

    echo"</tr><tr>";

    echo "<td><a href='similarTitle.php'> Primerjaj nazive izdelkov </a></td>";
    echo "<td><a href='similarDescription.php'> Primerjaj opis izdelkov </a></td>";

    echo "</tr>";
    echo "</table>";
}
echo "<h1>Uporabniki</h1>";
if(isset($_SESSION['Name']) && isset($_SESSION['Surname'])&& $_SESSION['Admin']==1)
{
$sql = "SELECT * FROM Users";
$result = $conn->query($sql);
echo "<table border='1'>
<tr>
<th>Ime</th>
<th>Priimek</th>
<th>Email</th>
<th>Administrator</th>
<th>Uredi</th>
<th>Odstrani</th>
</tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<form action='editUsers.php?id=".$row['ID']. "' method='POST'>";
        echo "<tr>";
        echo "<td><input type='text' name='Name' value='" . $row['Name'] . "' /><br></td>";
        echo "<td><input type='text' name='LastName' value='" . $row['LastName'] . "' /><br></td>";
        echo "<td><input type='text' name='Email' value='" . $row['Email'] . "' /><br></td>";
        if($row['Admin']==1){
       echo "<td><input type='checkbox' name='Admin' value='1' checked='checked'/><br></td>";
            }
        else{
       echo "<td><input type='checkbox' name='Admin' value='0'/><br></td>";
            }
        echo "<td><input type='submit' name='Spremeni'  value='Spremeni' /></td>";
        echo "<td><input type='submit' name='Odstrani' value='Odstrani'></td>";
        echo "</tr>";
        echo "</form>";
    }
}
echo "</table>";
}
?>

<?php 
echo "<h1>Trgovine</h1>";
if(isset($_SESSION['Name']) && isset($_SESSION['Surname'])&& $_SESSION['Admin']==1)
{
$sql = "SELECT * FROM Stores";
$result = $conn->query($sql);
echo "<table border='1'>
<tr>
<th>Ime</th>
<th>URL trgovine</th>
<th>URL prikazne slike</th>
<th>Uredi</th>
<th>Odstrani</th>
</tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<form action='editStore.php?id=".$row['ID']. "' method='POST'>";
        echo "<tr>";
        echo "<td><input type='text' name='Name' value='" . $row['Name'] . "' /><br></td>";
        echo "<td><input type='text' name='StoreURL' value='" . $row['StoreURL'] . "' /><br></td>";
        echo "<td><input type='text' name='LogoURL' value='" . $row['LogoURL'] . "' /><br></td>";
        echo "<td><input type='submit' name='Spremeni'  value='Spremeni' /></td>";
        echo "<td><input type='submit' name='Odstrani' value='Odstrani'></td>";
        echo "</tr>";
        echo "</form>";
    }
}
echo "</table>";
}
?>
<?php 
echo "<h1>Izdelki</h1>";
if(isset($_SESSION['Name']) && isset($_SESSION['Surname'])&& $_SESSION['Admin']==1)
{
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);
echo "<table border='1'>
<tr>
<th>Naziv</th>
<th>URL</th>
<th>Cena</th>
<th>Ocena</th>
<th>Opis</th>
<th>Kategorija</th>
<th>Uredi</th>
<th>Odstrani</th>
</tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $result2 = $conn->query("SELECT categories.ID, categories.Title as kat FROM categories INNER JOIN products ON products.Categories_ID = categories.ID WHERE products.ID =".$row['ID']);
        echo "<form action='editProduct.php?id=".$row['ID']. "' method='POST'>";
        echo "<tr>";
        echo "<td><input type='text' name='Title' value='" . $row['Title'] . "' /><br></td>";
        echo "<td><input type='text' name='ProductURL' value='" . $row['ProductURL'] . "' /><br></td>";
        echo "<td><input type='text' name='Price' value='" . $row['Price'] . "' /><br></td>";
        echo "<td><input type='text' name='Rating' value='" . $row['Rating'] . "' /><br></td>";
        echo "<td><input type='text' name='Description' value='" . $row['Description'] . "' /><br></td>";
        echo "<td><select name='Categories_ID'>"
                . ""; if($result2->num_rows > 0){while($row2 = $result2->fetch_assoc()) {if($row2['ID']==$row['Categories_ID']){echo "<option value='" .
                $row2['ID'] . "'selected>" . $row2['kat'] . "</option>";}else{echo "<option value='" .
                $row2['ID'] . "'>" . $row2['Title'] . "</option>";}}} echo "</select></td>";
        echo "<td><input type='submit' name='Spremeni'  value='Spremeni' /></td>";
        echo "<td><input type='submit' name='Odstrani' value='Odstrani'></td>";
        echo "</tr>";
        echo "</form>";
    }
}
echo "</table>";
}
?>
<?php 
include "footer.php";
?>
