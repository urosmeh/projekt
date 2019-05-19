<?php
include_once "session.php";
include 'db.php';

$sql  = "SELECT DateTime FROM Products LIMIT 1";
$query = mysqli_query($conn, $sql);
if(mysqli_num_rows($query) == 1)
{
    $row = mysqli_fetch_assoc($query);
    $timeFromDB = strtotime($row['DateTime']);
    if(time()-$timeFromDB >= 43200 )
    {
        //include_once 'scraper_BigBang.php';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Primerjalko</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <!-- TO SM DODAV -->
     <link rel="stylesheet" type="text/css" href="Css.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
           integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">  -->
    <!-- STARS RATING-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- PRICE SLIDER-->
    <link href="https//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css"  media="screen">

   <!-- PRICE SLIDER -->
</head>
<body id="top">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row0">
  <div id="topbar" class="hoc clear">
    <!-- ################################################################################################ -->
    <div class="fl_left">
      <ul class="nospace inline pushright">
          <?php
          if(isset($_SESSION['Name']) && isset($_SESSION['Surname']))
          {
              echo "<li><i class='fa fa-sign-in'></i> <a href='favorites.php'>Priljubljeno</a></li>";
              if( $_SESSION['Admin']==1){
              echo "<li><i class='fa fa-sign-in'></i> <a href='admin.php'>Administracija</a></li>";
              }
              echo "<li><i class='fa fa-user'></i> <a href='logout.php'>Odjava</a></li>";
          }
          else
          {
              echo "<li><i class='fa fa-sign-in'></i> <a href='login.php'>Prijava</a></li>";
              echo "<li><i class='fa fa-user'></i> <a href='register.php'>Registracija</a></li>";
          }
          ?>

      </ul>
    </div>
      <!--PRIJAVA ....

      ISKANJE -->


    <div class="fl_right">
      <form class="clear" method="post" action="results.php">
        <fieldset>
          <legend>Search:</legend>
          <input type="search" value="" name="search_value" placeholder="Išči tukaj&hellip;">
          <button class="fa fa-search" type="submit" title="Search"><em>Iskanje</em></button>
        </fieldset>
      </form>
    </div>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row1">
  <header id="header" class="hoc clear">
    <!-- ################################################################################################ -->
    <div id="logo" class="fl_left">
      <h1><a href="index.php">Primerjalko</a></h1>
      <i class="fa fa-map-o"></i>
      <p>najboljše trgovanje</p>
    </div>
    <!-- ################################################################################################ -->
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="index.php">Domov</a></li>
      </ul>
    </nav>
    <!-- ################################################################################################ -->
  </header>
</div>