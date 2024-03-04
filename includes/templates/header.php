<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8"/>
    <title>admin</title>
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/css/bootstrap.css">
    <link rel="stylesheet" href="layout/css/jquery-ui.css">
    <link rel="stylesheet" href="layout/css/jquery.selectBoxIt.css">
    <link rel="stylesheet" href="layout/css/front.css">
    </head>
    <body class="homepage">
        <div xlass="upper-bar">
            <div class="container">
<?php


if (isset($_SESSION['user'])){
    echo 'Welcome    ' .   $sessionUser.'  ';
    echo '<a href="profil.php">Profile</a>';
    
    echo '   - <a href="logout.php">Logout</a>';
  if(chekUserStatus($sessionUser) ==1){
    //echo 'your membership need activate by admin';
  }
}
else {
?>
              <a href="login.php">
                <span class="pull-right">Login/Signup</span>
              </a>
<?php }?>
</div>


        </div>
        



    <nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Homepage</a>
    </div>

    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        <?php
        // $categories = getCat();
        foreach ( getCat() as $cat ){
          echo '<li><a href="categories.php?pageid='.$cat['ID'].'&pagename='.str_replace('','-',$cat['Name']).'">'. $cat['Name'].'</a></li>';
        }
        ?>
      </ul>
     
   
    </div>
  </div>
</nav>
    