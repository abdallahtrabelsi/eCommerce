<?php
session_start();
$noNavbar='';
$pageTitle='Login';
if (isset($_SESSION['userName'])){
    header('Location:dashboard.php'); 
}
include 'init.php';
?>
<h1 >login</h1>
<?php
if($_SERVER['REQUEST_METHOD'] =='POST'){
    $username=$_POST['user'];
    $password=$_POST['pass'];
    $hashedPass= sha1($password);
    
    $stmt = $con-> prepare("SELECT userID,userName,password 
    FROM users WHERE userName=? AND password =?
     AND GroupeID= 1 LIMIT 1");
  $stmt-> execute (array($username,$hashedPass));
  $row =$stmt->fetch();
  $count=$stmt-> rowCount();
if ($count>0){
    $_SESSION['userName']=$username; 
    $_SESSION['ID'] = $row['userID'];
    header('Location:dashboard.php'); 
    exit();
}

  
}

?>

<?php
include "includes/templates/header.php"
?>

<?php
include "includes/templates/footer.php"
?>


<form class="login" action=<?php echo $_SERVER['PHP_SELF'] ?> method="POST">
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off"/>
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password"/>
    <input class="btn btn-primary btn-block" type="submit" value="login"/>
</form>
