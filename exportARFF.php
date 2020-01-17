
<?php 
include "header.php"; 
include_once "db.php"; 
include_once "session.php";
?>

<?php
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);
$file = "c\\laptops.arff";
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
    fwrite($filestream, "@attribute VALUE {GOOD, AVG, BAD}\n");
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
            $valOfConfig = 0;
            if($price <= 200){
                $valToWrite .= "0-200,";
                $valOfConfig++;
            }
            else if($price >= 201 && $price <= 400)
            {
                $valToWrite .= "201-400,";
                $valOfConfig += 2;
            }
            else if($price >= 401 && $price <= 600)
            {
                $valToWrite .= "401-600,";
                $valOfConfig += 4;
            }
            else if($price >= 601 && $price <= 800)
            {
                $valToWrite .= "601-800,";
                $valOfConfig += 6;
            }
            else if($price >= 801 && $price <= 1000)
            {
                $valToWrite .= "801-1000,";
                $valOfConfig += 8;
            }
            else if($price >= 1001 && $price <= 1200)
            {
                $valToWrite .= "1001-1200,"; 
                $valOfConfig += 10;
            }   
            else
            {
                $valToWrite .= "1201+,";
                $valOfConfig += 12;
            }
                


                print_r($specs);
                echo "<br>";
            $val = $specs[0];
            if(strpos($val, "i3") !== false)
            {
                $valToWrite .="i3,";
                $valOfConfig += 1;
            }
            else if(strpos($val, "i5") !== false)
            {
                $valToWrite .="i5,";
                $valOfConfig += 2;
            }
            else if(strpos($val, "i7") !== false)
            {
                $valToWrite .="i7,";
                $valOfConfig += 4;
            }
            else if(strpos($val, "i9") !== false)
            {
                $valToWrite .="i9,";
                $valOfConfig += 8;
            }
            else if(strpos($val, "Ryzen3") !== false || strpos($val, "Ryz3") !== false)
            {
                $valToWrite .="Ryzen3,";
                $valOfConfig += 3;
            }
            else if(strpos($val, "Ryzen5") !== false || strpos($val, "Ryz5") !== false)
            {
                $valToWrite .="Ryzen5,";
                $valOfConfig += 5;
            }
            else if(strpos($val, "Ryzen7") !== false || strpos($val, "Ryz7") !== false)
            {
                $valToWrite .="Ryzen7,";
                $valOfConfig += 7;
            }
            else
            {
                $valToWrite .="othr,";

            }
            
            $val = $specs[1];
            
            if(strpos($val, "8") !== false)
            {
                $valToWrite .="8,";
                $valOfConfig += 2;
            }
            else if(strpos($val, "16") !== false)
            {
                $valToWrite .="16,";
                $valOfConfig += 3;
            }
            else if(strpos($val, "32") !== false)
            {
                $valToWrite .="32+,";
                $valOfConfig += 4;
            }
            else if(strpos($val, "4") !== false)
            {
                $valToWrite .="4,";
                $valOfConfig += 1;
            }
            else
            {
                $valToWrite .= "ND,";
            }
  
            if($valOfConfig > 0 && $valOfConfig <= 8)
                $valToWrite .= "BAD";
            else if(($valOfConfig >= 9 && $valOfConfig <= 16))
                $valToWrite .= "AVG";
            else
                $valToWrite .= "GOOD";

            echo $valToWrite."<br>";
            $filestream = fopen($file, "a") or die();
            fwrite($filestream, $valToWrite."\n");
        }

        exec("start c\prog.exe");
    }
}


?>