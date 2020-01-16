
<?php 
include "header.php"; 
include_once "db.php"; 
include_once "session.php";
?>

<?php
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);
$file = "laptops.arff";
if(file_exists($file) == false)
{
    //create ARFF header

    $filestream = fopen($file, "w") or die();
    echo "WUTUFUK";
    fwrite($filestream, "@relation laptops\n");
    fwrite($filestream, "@attribute Znamka {DELL, HP, ACER, ASUS, LENOVO, RAZER, MICROSOFT, XMG, MSI, OTHR}\n");
    fwrite($filestream, "@attribute Cena {0-200, 201-400, 401-600, 601-800, 801-1000, 1001-1200, 1201+}\n");
    fwrite($filestream, "@attribute Proc {i3, i5, i7, i9, Ryzen5, Ryzen3, Ryzen7, othr}\n");
    fwrite($filestream, "@attribute RAM {4, 8, 16, 32+, ND}\n");
    fwrite($filestream, "@data\n");
}
else
{
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $Title = $row['Title'];
            $price = $row['Price'];
            $Title_arr = explode(" ", $Title);
            $specs = "";
            foreach($Title_arr as $str)
            {
                if(strpos($str, "/") !== false)
                {
                    $specs = explode("/", $str);
                    break;
                }
            }
            
            if($Title_arr[0] == "DELL" || $Title_arr[0] == "HP" || $Title_arr[0] == "ACER" ||$Title_arr[0] == "ASUS" || $Title_arr[0] == "LENOVO" || $Title_arr[0] == "RAZER" || $Title_arr[0] == "MICROSOFT" || $Title_arr[0] == "XMG" ||$Title_arr[0] == "MSI")
                $valToWrite = $Title_arr[0].",";
            else
            $valToWrite = "OTHR,";

            if($price <= 200)
                $valToWrite .= "0-200,";
            else if($price >= 201 && $price <= 400)
                $valToWrite .= "201-400,";
            else if($price >= 401 && $price <= 600)
                $valToWrite .= "401-600,";
            else if($price >= 601 && $price <= 800)
                $valToWrite .= "601-800,";
            else if($price >= 801 && $price <= 1000)
                $valToWrite .= "801-1000,";
            else if($price >= 1001 && $price <= 1200)
                $valToWrite .= "1001-1200,";   
            else
                $valToWrite .= "1201+,";


                print_r($specs);
                echo "<br>";
            $val = $specs[0];
            if(strpos($val, "i3") !== false)
            {
                $valToWrite .="i3,";
            }
            else if(strpos($val, "i5") !== false)
            {
                $valToWrite .="i5,";
            }
            else if(strpos($val, "i7") !== false)
            {
                $valToWrite .="i7,";
            }
            else if(strpos($val, "i9") !== false)
            {
                $valToWrite .="i9,";
            }
            else if(strpos($val, "Ryzen3") !== false || strpos($val, "Ryz3") !== false)
            {
                $valToWrite .="Ryzen3,";
            }
            else if(strpos($val, "Ryzen5") !== false || strpos($val, "Ryz5") !== false)
            {
                $valToWrite .="Ryzen5,";
            }
            else if(strpos($val, "Ryzen7") !== false || strpos($val, "Ryz7") !== false)
            {
                $valToWrite .="Ryzen7,";
            }
            else
            {
                $valToWrite .="othr,";
            }
            
            $val = $specs[1];
            
            if(strpos($val, "8") !== false)
            {
                $valToWrite .="8";
            }
            else if(strpos($val, "16") !== false)
            {
                $valToWrite .="16";
            }
            else if(strpos($val, "32") !== false)
            {
                $valToWrite .="32+";
            }
            else if(strpos($val, "4") !== false)
            {
                $valToWrite .="4";
            }
            else
            {
                $valToWrite .= "ND";
            }
  

            echo $valToWrite."<br>";
            $filestream = fopen($file, "a") or die();
            fwrite($filestream, $valToWrite."\n");
        }
    }
}


?>