<?php
session_start();
$_pageTitle='members';
if (isset($_SESSION['userName'])){
    

  
   include 'init.php';
   $do=isset($_GET['do']) ? $_GET['do']: 'Manage';
    if ($do == 'Manage')
    {
        $query='';
        if (isset($_GET['page']) && $_GET['page']== 'Pending'){
            $query='AND RegStatus=0';
        }
    //    $value= "abdallah";
    //   $check = checkItem ("userName","users",$value);
    //   if ($check === 1)
    //   {
    //       echo 'cool';
    //   }
        $stmt=$con->prepare("SELECT * From users WHERE GroupeID != 1 $query");
        $stmt->execute();
        $rows =$stmt->fetchAll();

        ?>
    <h1 class="text-center">Manage Member</h1>
    <div class="container">
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
            <tr>
                <td>#ID</td>
                <td>Username</td>
                <td>Email</td>
                <td>FullName</td>
                <td>Registre Date</td>
                <td>Control</td>
            </tr>
            <?php 
            foreach($rows as $row){
                echo "<tr>";
                    echo "<td>".$row['userID']."</td>";
                    echo "<td>".$row['userName']."</td>";
                    echo "<td>".$row['Email']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['Date']."</td>";
                  
                    echo "<td>
                    <a href='members.php?do=Edit&userID=".$row['userID']."' class='btn btn-success'><i class ='fa fa-edit'></i>Edite</a>
                    <a href='members.php?do=Delete&userID=".$row['userID']."' class='btn btn-danger confirm'><i class ='fa fa-close'></i>Delete</a> ";
                    if($row ['RegStatus'] == 0){
                        echo"<a href='members.php?do=Activate&userID=".$row['userID']."' class='btn btn-info'><i class ='fa fa-edit'></i>Activate</a>";
                    }
                          echo"</td>";
                echo "</tr>";
            }
            ?>
           
        </table>
    </div>
        <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add New Member</a>
    </div>







<!-- <a href="members.php?do=Add">; -->
<?php
    }
    elseif ($do =='Add'){?>


<h1 class="text-centre">Add new Member</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
              
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="no" >

                        </div>
                </div>   
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 col-md-4">
                        
                            <input type="password" name="password" class="form-control"  required="required" placeholder="no" >

                        </div>
                </div>  
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="Email" name="email" class="form-control" placeholder="no"  >

                        </div>
                </div>  
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">FullName</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="FullName" class="form-control"  placeholder="no">

                        </div>
              
                </div>    
                <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Add Member" class="btn btn-primary btn-lg">
                </div>
                        

                       
                </div>   
            </form>
        </div>
    <?php
    
} elseif($do =='Insert'){

   // echo $_POST['username'].$_POST['password'].$_POST['email'].$_POST['FullName'];
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST')

        {
            echo "<h1 class='text-center'>Insert Members</h1>";
        echo"<div class='container'>";
            
             $user =$_POST['username'];
             $pass =$_POST['password'];
             $email =$_POST['email'];
             $name =$_POST['FullName'];
            $hashPass =sha1($_POST['password']);
            //        echo $id.$user.$email.$name;
           

        

               $formErrors=array();
               if (strlen($user)  < 4){
                $formErrors[] = 'user name cant be less than 4 caractere <strong> empty </strong>';
               }
               if (strlen($user)  > 20){
                $formErrors[] = 'user name cant be more than 20 caractere <strong> empty </strong>';
               }

             //  if (empty($user)){
             //   $formErrors[] ='<div class="alert alert-danger">user cant be   <strong> empty </strong></div>';

            //}
            

             if (empty($email)){
                 $formErrors[] ='<strong> empty </strong>';
                 
             }
             if (empty($name)){
                $formErrors[] ='name cant be <strong> empty </strong>';
                
            
            }
            foreach($formErrors as $error){
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
       
    if (empty ($formErrors)){

    
            $stmt=$con->prepare("INSERT INTO users
                                             (userName,Password,Email,name,RegStatus,Date)
                                                VALUES (:zuser,:zpass,:zmail,:zname,1,now())");
                                                $stmt->execute(array(
                                                                 'zuser'=>$user,
                                                                 'zpass'=>$hashPass,
                                                                 'zmail'=>$email,
                                                                 'zname'=>$name
                                                                ));
           // $stmt-> execute(array($user,$email,$name,$pass ));
            //    echo "<div class='alert alert-success'>". $stmt-> rowCount().'Record Updated';
            }
        }
        else {
             $errorMsg ='sorry';
             redirectHome($errorMsg);
            
        }
        echo "</div>";
    
    }
           

    elseif($do == 'Edit'){ 
        $userid=isset($_GET['userID'])&& is_numeric($_GET['userID'])  ? intval($_GET['userID']) :0;

        $stmt = $con-> prepare("SELECT 
                                   * 
        FROM users WHERE userID=?  LIMIT 1");
      $stmt-> execute (array($userid));
      $row =$stmt->fetch();
      $count=$stmt-> rowCount();

      if($stmt->rowCount() > 0){
        
        ?>

        <h1 class="text-centre">Edit Member</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="userID" value="<?php echo $userid?>"/>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $row['userName'] ?>" required="required">

                        </div>
                </div>   
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 col-md-4">
                        <input type="hidden" name="oldpassword" value="<?php echo $row['password']?>">
                            <input type="password" name="newpassword" class="form-control" autocomplete="new-password" required="required" >

                        </div>
                </div>  
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="Email" name="email" class="form-control" value="<?php echo $row['Email'] ?>">

                        </div>
                </div>  
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">FullName</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="FullName" class="form-control" value="<?php echo $row['name'] ?>">

                        </div>
              
                </div>    
                <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Save" class="btn btn-primary btn-lg">
                </div>
                        

                       
                </div>   
            </form>
        </div>
      <?php 
      }
    else{
        echo 'no';
   
    }}elseif($do == 'Update') {
        # code...
        
        echo "<h1 class='text-center'>Update Memebers</h1>";
        echo"<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
             $id =$_POST['userID'];
             $user =$_POST['username'];
             $email =$_POST['email'];
             $name =$_POST['FullName'];

            //        echo $id.$user.$email.$name;
            $pass=empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;

        

               $formErrors=array();
               if (strlen($user)  < 4){
                $formErrors[] = '<div class="alert alert-danger">user name cant be less than 4 caractere <strong> empty </strong></div>';
               }
               if (strlen($user)  > 20){
                $formErrors[] = '<div class=alert alert-danger">user name cant be more than 20 caractere <strong> empty </strong></div>';
               }

             //  if (empty($user)){
             //   $formErrors[] ='<div class="alert alert-danger">user cant be   <strong> empty </strong></div>';

            //}
            

             if (empty($email)){
                 $formErrors[] ='<div class="alert alert-danger">email cant be   <strong> empty </strong></div>';
                 
             }
             if (empty($name)){
                $formErrors[] ='<div class="alert alert-danger">name cant be <strong> empty </strong></div>';
                
            
            }
            foreach($formErrors as $error){
                echo $error.'<br>';
            }
       
    if (empty ($formErrors)){

    
            $stmt=$con->prepare("UPDATE users SET username =? ,Email= ? ,name =? ,Password= ? WHERE userID=?  ");
            $stmt-> execute(array($user,$email,$name,$pass, $id ));
                echo "<div class='alert alert-success'>". $stmt-> rowCount().'Record Updated';
            }
        }
        else {
            echo 'sorry';
        }
        echo "</div>";
    }

elseif ($do=='Delete'){

    echo "<h1 class='text-center'>Delete Memebers</h1>";
    echo"<div class='container'>";
    $userid=isset($_GET['userID'])&& is_numeric($_GET['userID'])  ? intval($_GET['userID']) :0;

    $stmt = $con-> prepare("SELECT 
                               * 
    FROM users WHERE userID=?  LIMIT 1");
  $stmt-> execute (array($userid));
  
  $count=$stmt-> rowCount();

  if($stmt->rowCount() > 0){
        $stmt =$con -> prepare ("DELETE FROM users WHERE userID = :zuser");
        $stmt -> bindParam(":zuser",$userid);
        $stmt -> execute();
        echo "<div class='alert alert-success'>". $stmt-> rowCount().'Record Delete</div>';

  }else 
  {
echo 'no ID';

  }
  echo'</div>';


}
elseif ($do =='Activate'){
    echo "<h1 class='text-center'>Activate Memebers</h1>";
    echo"<div class='container'>";
    $userid=isset($_GET['userID'])&& is_numeric($_GET['userID'])  ? intval($_GET['userID']) :0;
    $stmt = $con-> prepare("UPDATE 
    
 users SET  RegStatus=1 WHERE userID=?  ");
$stmt-> execute (array($userid));

$count=$stmt-> rowCount();


    include $tp1. 'footer.php';
}
else {
    header('Location: index.php');
    
    exit();
}}