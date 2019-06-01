 <?php
$servername = "localhost";
$username = "id9801034_root";
$password = "navi4ivan";
$database_name = "id9801034_primerjalko";

$conn = new mysqli($servername, $username, $password, $database_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?> 