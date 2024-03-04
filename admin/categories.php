<?php

ob_start();
session_start();
$pageTitle ='Categories';
if (isset($_SESSION ['userName'])){
    include'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] :'Manage';
    if ($do =='Manage'){

    

           
            $stmt2=$con->prepare("SELECT * From categories  ");
        $stmt2->execute();
        $cats =$stmt2->fetchAll();

        ?>
    <h1 class="text-center">Manage categories</h1>
    <div class="container categories">
    <div class="panel panel-default">
      <div class="panel-heading">Manage Categories
          
      </div>
            <div class="panel-body">
            
            
        
            <?php 

                    foreach($cats as $cat) {
                                    echo "<div class='cat'>";
                                    echo "<div class='hidden-buttons'>";
                                    echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>  ";
                                    echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
                                    echo "</div>";
                                    echo "<h3>" . $cat ['Name'] .'</h3> ';
                                    echo "<p>" . $cat ['Description'] .'</p> ';
          if ($cat['Visibility']==1){  echo '<span class="visibility">Hidden</span> ' ;  }
          if ($cat['Allow_Comment']==1){  echo '<span class="commenting">Comment Disabled</span> ';}
          if ($cat['Allow_Ads']==1){  echo '<span class="advertises">Ads Disabled</span>';}
                            echo "</div>";
                            echo "<hr>";
                    }
         
            ?>
           
      
        <a href="categories.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add New Categorie</a>
    </div></div></div>

<?php
    }
    elseif($do =='Add'){

?>
<h1 class="text-centre">Add new Category</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
              
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="no" >

                        </div>
                </div>   
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-4">
                        
                            <input type="text" name="description" class="form-control"  required="required" placeholder="no" >

                        </div>
                </div>  
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="ordering" class="form-control" placeholder="no"  >
 
                        </div>
                </div>  
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Visibile</label>
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input type="radio" name="visibility"  value="0" checked id="vis-yes">
                                <label for="vis-yes">yes</label>
                            </div>
                            <div>
                                <input type="radio" name="visibility"  value="1" checked id="vis-no">
                                <label for="vis-no">no</label>
                            </div>

                        </div>
              
                </div>    
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow Commenting</label>
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input type="radio" name="commenting"  value="0" checked id="com-yes">
                                <label for="com-yes">yes</label>
                            </div>
                            <div>
                                <input type="radio" name="commenting"  value="1" checked id="com-no">
                                <label for="com-no">no</label>
                            </div>

                        </div>
              
                </div>    
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input type="radio" name="ads"  value="0" checked id="ads-yes">
                                <label for="ads-yes">yes</label>
                            </div>
                            <div>
                                <input type="radio" name="ads"  value="1" checked id="ads-no">
                                <label for="ads-no">no</label>
                            </div>

                        </div>
              
                </div> 
                <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Add category" class="btn btn-primary btn-lg">
                </div>
                        

                       
                </div>   
            </form>
        </div>

<?php
    }
    elseif($do =='Insert'){
      //  echo $_POST['name'].$_POST['description'].$_POST['ordering'].$_POST['visible'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST')

        {
            echo "<h1 class='text-center'>Insert Categorie</h1>";
        echo"<div class='container'>";
            
             $name =$_POST['name'];
             $description =$_POST['description'];
             $ordering =$_POST['ordering'];
             $visible =$_POST['visibility'];
             $comment =$_POST['commenting'];
             $ads =$_POST['ads'];

            
                    //   $check = chekItem("Name","categories",$name);
                    //   if($check==1){
                    //       $theMsg ='<div class="alert alert-danger">Sorry this category is exist</div>';
                    //       redirectHome ($theMsg,'back');
                    //   }

             $stmt=$con->prepare("INSERT INTO categories
             (Name,Description,Ordering,Visibility,Allow_Comment,Allow_Ads)
                VALUES (:zname,:zdescription,:zordering,:zvisibility,:zcomment,:zads)");


                $stmt->execute(array(
                                 'zname'=>$name,
                                 'zdescription'=>$description,
                                 'zordering'=>$ordering,
                                 'zvisibility'=>$visible,
                                 'zcomment'=>$comment,
                                 'zads'=>$ads
                                ));

 //$stmt-> execute(array($name,$description,$ordering,$visible));
   //echo "<div class='alert alert-success'>". $stmt-> rowCount().'Record Updated';

}
else {
echo 'false';
    }
    echo'</div>';
    }

elseif($do =='Edit'){
    $userid=isset($_GET['ID'])&& is_numeric($_GET['ID'])  ? intval($_GET['ID']) :0;

    $stmt = $con-> prepare("SELECT 
                               * 
    FROM categories WHERE ID=? ");
  $stmt-> execute (array($userid));
  $row =$stmt->fetch();
  $count=$stmt-> rowCount();

  if($stmt->rowCount() > 0){
    
    ?>

    <h1 class="text-centre">Edit categories</h1>
    <div class="container">
        <form class="form-horizontal" action="?do=Update" method="POST">
            <input type="hidden" name="ID" value="<?php echo $userid ?>"/>
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">name</label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="name" class="form-control" autocomplete="off" value="<?php echo $row['Name'] ?>" required="required">

                    </div>
            </div>   
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">description</label>
                    <div class="col-sm-10 col-md-4">
                    
                         <input type="text" name="description"  class="form-control" value="<?php echo $row['Description']?>">

                    </div>
            </div>  
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Ordering</label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="ordering" class="form-control" value="<?php echo $row['Ordering'] ?>">

                    </div>
            </div>  
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">visible</label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="visible" class="form-control" value="<?php echo $row['Visibility'] ?>">

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

}

}
elseif($do =='Update'){
    echo "<h1 class='text-center'>Update categories</h1>";
    echo"<div class='container'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
       $id =$_POST['ID'];
        $name =$_POST['name'];
        $description =$_POST['description'];
        $ordering =$_POST['ordering'];
        $visible =$_POST['visible'];

        // echo $name;

        $stmt=$con->prepare("UPDATE categories SET Name =? ,Description= ? ,Ordering =? ,Visibility= ? WHERE ID=?  ");
        $stmt-> execute(array($name,$description,$ordering,$visible,$id ));
            echo "<div class='alert alert-success'>". $stmt-> rowCount().'Record Updated';
        }
    
    else {
        echo 'sorry';
    }
    echo "</div>";
}

elseif($do =='Delete'){
        

    echo "<h1 class='text-center'>Delete Categorie</h1>";
    echo"<div class='container'>";
    $userid=isset($_GET['ID'])&& is_numeric($_GET['ID'])  ? intval($_GET['ID']) :0;

    $stmt = $con-> prepare("SELECT 
                               * 
    FROM categories WHERE ID=? ");
  $stmt-> execute (array($userid));
  
  $count=$stmt-> rowCount();

  if($stmt->rowCount() > 0){
        $stmt =$con -> prepare ("DELETE FROM categories WHERE ID = :zuser");
        $stmt -> bindParam(":zuser",$userid);
        $stmt -> execute();
        echo "<div class='alert alert-success'>". $stmt-> rowCount().'Record Delete</div>';

  }else 
  {
echo 'no ID';

  }
  echo'</div>';


}
//elseif($do =='Activate'){
        

//}


    include $tp1. 'footer.php';
}
else {
    header('Location: index.php');
    
    exit();
}

ob_end_flush();
?>