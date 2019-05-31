<?php

include('simple_html_dom.php');
include "db.php";

/*
 * KATEGORIJA: prenosniki
 */
$query = mysqli_query($conn, "SELECT ID, StoreURL FROM stores WHERE StoreURL = 'https://www.bigbang.si'");
$store_id = 0;
if(mysqli_num_rows($query) == 0)
{
    $query1 = mysqli_query($conn, "INSERT into stores(Name, StoreURL) VALUES('BigBang', 'https://www.bigbang.si')");
    $query = mysqli_query($conn, "SELECT ID, StoreURL FROM stores WHERE StoreURL = https://www.bigbang.si");
    $row = mysqli_fetch_assoc($query);
    $store_id = $row['ID'];
}
else
{
    $row = mysqli_fetch_assoc($query);
    $store_id = $row['ID'];
}

for ($i = 1; $i < 40; $i++) {
    $html = file_get_html('https://www.bigbang.si/prenosni-racunalniki?pricefrom=190&priceto=4000&pagenumber=' . $i);

    $konec = explode('Ni artiklov, ki bi ustrezali izbranim kriterijem', $html);
    if ( strlen($konec[0]) < 189000) { //pride skoz vse podstrani
        break;
    }

    foreach ($html->find('div.product-box') as $element) {

        $item[] = $element->find('h3', 0)->plaintext; //title
        $title = $element->find('h3', 0)->plaintext;
        $link = "https://www.bigbang.si";
        $linkDesc = $link . $element->find('h3 a', 0)->href; //url

        $htmlDesc = file_get_html($linkDesc);
        $item[] = $htmlDesc->find('div.productDescription p', 0)->plaintext; //description
        $description = $htmlDesc->find('div.productDescription p', 0)->plaintext;
        $price = $element->find('div.price', 0)->plaintext; //price
        $price1 = explode("€", $price);
        if (strlen($price1[1]) == 26){
            $priceNew = $price1[0];
        }else{
            $priceNew = $price1[1];
        }
        $item[] = $priceNew;
        $priceNew = str_replace(",", ".", $priceNew);
        $item[] = $linkDesc; //url

        $item[] = $htmlDesc->find('div.mainImage a img', 0)->src; //picture
        $img = $htmlDesc->find('div.mainImage a img', 0)->src;

        $date = date("Y-m-d H:i:s");
        $query = mysqli_query($conn, "INSERT INTO products(Title, ProductURL, Price, DateTime, Description,Rating, Stores_ID, Categories_ID) VALUES('$title', '$linkDesc', $priceNew, '$date', '$description', 0, $store_id, (SELECT ID FROM categories WHERE Title = 'Prenosniki'))");
        $query2 = mysqli_query($conn, "INSERT INTO pictures(url, Title, Products_ID) VALUES('$img', '$title', (SELECT ID FROM products WHERE ProductURL = '$linkDesc'))");
        //echo "INSERT INTO Products(Title, ProductURL, Price, DateTime, Description,Rating, Stores_ID, Categories_ID) VALUES('$title', '$linkDesc', $priceNew, '$date', '$description', 0, $store_id, SELECT ID FROM categories WHERE Title = 'Telefoni')"."<br>";

    }
}
