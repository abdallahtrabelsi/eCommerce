<?php
ob_start();
session_start();
$pageTitle ='Items';
if (isset($_SESSION ['userName'])){
    include'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] :'Manage';


    if ($do == 'Manage')
    {
    //    $value= "abdallah";
    //   $check = checkItem ("userName","users",$value);
    //   if ($check === 1)
    //   {
    //       echo 'cool';
    //   }
        $stmt=$con->prepare("SELECT items.* , categories.Name AS category_name,users.userName FROM items
         INNER JOIN categories ON categories.ID =items.Cat_ID 
        
        INNER JOIN users ON users.UserID =items.Member_ID");
        $stmt->execute();
        $items =$stmt->fetchAll();

        ?>
    <h1 class="text-center">Manage Items</h1>
    <div class="container">
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
            <tr>
                <td>#ID</td>
                <td>Name</td>
                <td>Description</td>
                <td>Price</td>
                <td>Adding Date</td>
                <td>Category</td>
                <td>Username</td>
                <!-- <td>Image</td> -->
                <td>Control</td>
            </tr>
            <?php 
            foreach($items as $item){
                echo "<tr>";
                echo "<td>" . $item['Item_ID'] . "</td>";
                echo "<td>" . $item['Name'] . "</td>";
                echo "<td>" . $item['Description'] . "</td>";
                echo "<td>" . $item['Price'] . "</td>";
                echo "<td>" . $item['Add_Date'] ."</td>";
                echo "<td>" . $item['category_name'] ."</td>";
                echo "<td>" . $item['userName'] ."</td>";
              //  echo "<td>" . $item['Image'] ."</td>";
                echo "<td>
                    <a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                    <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
                    if ($item['Approve'] == 0) {
                        echo "<a 
                                href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' 
                                class='btn btn-info activate'>
                                <i class='fa fa-check'></i> Approve</a>";
                    }
                echo "</td>";
            echo "</tr>";
            }
            ?>
           
        </table>
    </div>
        <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add New Item</a>
    </div>







<!-- <a href="members.php?do=Add">; -->
<?php
    }
    elseif ($do =='Add')
{

    ?>


<h1 class="text-centre">Add new Item</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">




            <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="file" name="image" class="form-control"  id ="image" placeholder="no" >
<br>
                        </div>
                </div>   






                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="name" class="form-control"   placeholder="no" >

                        </div>
                </div>   
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="description" class="form-control"  placeholder="no" >

                        </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="price" class="form-control"   placeholder="no" >

                        </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="country" class="form-control"   placeholder="no" >

                        </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10 col-md-6">
                           <select  name="status">
                           <option value="0">...</option>
                           <option value="1">New</option>
                           <option value="2">Like New</option>
                           <option value="3">Used</option>
                           <option value="4">Very Old</option>
                            </select>

                        </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10 col-md-4">
                           <select  name="member">
                           <option value="0">...</option>
                           <?php
                            $stmt=$con->prepare("SELECT * FROM users");
                            $stmt ->execute();
                            $users = $stmt->fetchAll();
                            foreach($users as $user){
                          echo "<option value='".$user['userID']."'>".$user['userName']."</option>";
                            }
                            ?>
                           </select>

                        </div>
                </div>
                
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10 col-md-4">
                           <select  name="category">
                           <option value="0">...</option>
                           <?php
                            $stmt2=$con->prepare("SELECT * FROM categories");
                            $stmt2 ->execute();
                            $cats = $stmt2->fetchAll();
                            foreach($cats as $cat){
                          echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                            }
                            ?>
                           </select>

                        </div>
                </div>
                <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Tags</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="tags" 
								class="form-control" 
								placeholder="Separate Tags With Comma (,)" />
						</div>
					</div>
                <div class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Add Item" class="btn btn-primary btn-lg">
                </div>
                        

                       
                </div>   
            </form>
        </div>

<?php

}
elseif($do =='Insert'){
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    echo "<h1 class='text-center'>Insert Item</h1>";
    echo "<div class='container'>";
  //  $target ="image/".basename($_FILES['image']['name']);
   
    // $image		= $_FILES['image']['tmp_name'];
    // // $image=file_get_contents($image);
    // // $image=base64_encode($image);


    $image =$_FILES['image'];
    $imageName=$_FILES['image']['name'];
    $imageSize=$_FILES['image']['size'];
    $imageTmp=$_FILES['image']['tmp_name'];
    $imageType=$_FILES['image']['type'];


    $imageExtension=array("jpeg","jpg","png","gif");
    $imageExtension1=strtolower (end(explode('.',$imageName)));




    $name		= $_POST['name'];
    $desc 		= $_POST['description'];
    $price 		= $_POST['price'];
    $country 	= $_POST['country'];
    $status 	= $_POST['status'];
    $member 	= $_POST['member'];
    $cat 		= $_POST['category'];
    $tags 		= $_POST['tags'];

    
    $formErrors = array();

    if (empty($name)) {
        $formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
    }

    if (empty($desc)) {
        $formErrors[] = 'Description Can\'t be <strong>Empty</strong>';
    }

    if (empty($price)) {
        $formErrors[] = 'Price Can\'t be <strong>Empty</strong>';
    }

    if (empty($country)) {
        $formErrors[] = 'Country Can\'t be <strong>Empty</strong>';
    }

    if ($status == 0) {
        $formErrors[] = 'You Must Choose the <strong>Status</strong>';
    }

    if ($member == 0) {
        $formErrors[] = 'You Must Choose the <strong>Member</strong>';
    }

    if ($cat == 0) {
        $formErrors[] = 'You Must Choose the <strong>Category</strong>';
    }

    // Loop Into Errors Array And Echo It

    foreach($formErrors as $error) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }

    // Check If There's No Error Proceed The Update Operation

    if (empty($formErrors)) {

        // Insert Userinfo In Database
        $image= rand(0,10000).'_'.$imageName;
        move_uploaded_file($imageTmp,"image\\".$image);

        $stmt = $con->prepare("INSERT INTO 

            items(Name, Description, Price, Country_Made,Image, Status, Add_Date, Cat_ID, Member_ID, tags)

            VALUES(:zname, :zdesc, :zprice, :zcountry, :zimage,:zstatus, now(), :zcat, :zmember, :ztags)");

        $stmt->execute(array(
            
            'zname' 	=> $name,
            'zdesc' 	=> $desc,
            'zprice' 	=> $price,
            'zcountry' 	=> $country,
            'zimage'    => $image,
            'zstatus' 	=> $status,
            'zcat'		=> $cat,
            'zmember'	=> $member,
            'ztags'		=> $tags

        ));

        // Echo Success Message

        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

        redirectHome($theMsg, 20);

    }

} else {

    echo "<div class='container'>";

    $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

    redirectHome($theMsg);

    echo "</div>";

}

echo "</div>";

}
     elseif($do == 'Edit'){ 
        $itemid=isset($_GET['itemid'])&& is_numeric($_GET['itemid'])  ? intval($_GET['itemid']) :0;

        $stmt = $con-> prepare("SELECT 
                                   * 
        FROM items WHERE Item_ID = ? " );
      $stmt-> execute (array($itemid));
      $item =$stmt->fetch();
      $count=$stmt-> rowCount();

      if($count > 0 ) {
        
        ?>

<h1 class="text-centre">Edite Item</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST">
            <input type="hidden" name="itemid"   value ="<?php echo $itemid ?>" >
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="name" class="form-control"  value ="<?php echo $item['Name']?>" placeholder="no" >

                        </div>
                </div>   
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="description" class="form-control" value ="<?php echo $item['Description']?>" placeholder="no" >

                        </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="price" class="form-control"  value ="<?php echo $item['Price']?>" placeholder="no" >

                        </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="country" class="form-control"  value ="<?php echo $item['Country_Made']?>" placeholder="no" >

                        </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10 col-md-6">
                           <select  name="status">
                           <option value="0">...</option>
                           <option value="1" <?php if ($item['Status']==1) {echo'selected';}?>>New</option>
                           <option value="2" <?php if ($item['Status']==2) {echo'selected';}?>>Like New</option>
                           <option value="3" <?php if ($item['Status']==3) {echo'selected';}?>>Used</option>
                           <option value="4" <?php if ($item['Status']==4) {echo'selected';}?>>Very Old</option>
                            </select>

                        </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10 col-md-4">
                           <select  name="member">
                           <option value="0">...</option>
                           <?php
                            $stmt=$con->prepare("SELECT * FROM users");
                            $stmt ->execute();
                            $users = $stmt->fetchAll();
                            foreach($users as $user){
                          echo "<option value='".$user[userID]."'";
                           if ($item['Member_ID']==$user['userID']) {echo'selected';} 
                           echo">".$user['userName']."</option>";
                            }
                            ?>
                           </select>

                        </div>
                </div>
                
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10 col-md-4">
                           <select  name="category">
                           <option value="0">...</option>
                           <?php
                            $stmt2=$con->prepare("SELECT * FROM categories");
                            $stmt2 ->execute();
                            $cats = $stmt2->fetchAll();
                            foreach($cats as $cat){
                          echo "<option value='".$cat[ID]."'";
                          if ($item['Cat_ID']==$cat['ID']) {echo'selected';} 
                          echo">".$cat['Name']."</option>";
                            }
                            ?>
                           </select>

                        </div>
                </div>
                <div class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Save Item" class="btn btn-primary btn-lg">
                </div>
                        

                       
                </div>   
            </form>
        </div>

<?php

}
      
    // else{
    //     echo 'no';
   
    // }
}


elseif($do == 'Update') {
    # code...
    
    echo "<h1 class='text-center'>Update Item</h1>";
    echo"<div class='container'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
         $id =$_POST['itemid'];
         $name =$_POST['name'];
         $desc =$_POST['description'];
         $price =$_POST['price'];
         $country =$_POST['country'];
         $status =$_POST['status'];
         $member =$_POST['member'];
         $cat =$_POST['category'];


      

    
         $formErrors=array();
               
         //  if (empty($user)){
         //   $formErrors[] ='<div class="alert alert-danger">user cant be   <strong> empty </strong></div>';

        //}
        

         if (empty($desc)){
             $formErrors[] ='<strong> empty </strong>';
             
         }
         if (empty($price)){
            $formErrors[] ='price cant be <strong> empty </strong>';
            
        
        }
        if (empty($country)){
           $formErrors[] ='country cant be <strong> empty </strong>';
           
       
       }
       // if (status === 0){
       //     $formErrors[] =' <strong> empty </strong>';
           
       
       // }
        foreach($formErrors as $error){
            echo '<div class="alert alert-danger">'.$error.'</div>';
        }
   
   
if (empty ($formErrors)){


        $stmt=$con->prepare("UPDATE items SET Name =? ,Description= ? ,Price =? ,Country_Made= ?,Status= ?,Cat_ID= ? ,Member_ID= ? WHERE Item_ID=?  ");
        $stmt-> execute(array($name,$desc,$price,$country, $status,$cat,$member,$id ));
            echo "<div class='alert alert-success'>". $stmt-> rowCount().'Record Updated';
        }
    }
    else {
        echo 'sorry';
    }
    echo "</div>";
}



elseif ($do=='Delete'){

    echo "<h1 class='text-center'>Delete Item</h1>";
    echo"<div class='container'>";
    $itemid=isset($_GET['itemid'])&& is_numeric($_GET['itemid'])  ? intval($_GET['itemid']) :0;

    $stmt = $con-> prepare("SELECT 
                               * 
    FROM items WHERE Item_ID=?");
  $stmt-> execute (array($itemid));
  
  $count=$stmt-> rowCount();

  if($stmt->rowCount() > 0){
        $stmt =$con -> prepare ("DELETE FROM items WHERE Item_ID = :zItem_ID");
        $stmt -> bindParam(":zItem_ID",$itemid);
        $stmt -> execute();
        echo "<div class='alert alert-success'>". $stmt-> rowCount().'Record Delete</div>';

  }else 
  {
echo 'no ID';

  }
  echo'</div>';


}
    // include $tp1. 'footer.php';

    elseif ($do == 'Approve') {

        echo "<h1 class='text-center'>Approve Item</h1>";
        echo "<div class='container'>";

          

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;


            $check = chekItem('Item_ID', 'items', $itemid);

        
            if ($check > 0) {

                $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

                $stmt->execute(array($itemid));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

                redirectHome($theMsg, 'back');

            } else {

                $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

                redirectHome($theMsg);

            }

        echo '</div>';

    }
}