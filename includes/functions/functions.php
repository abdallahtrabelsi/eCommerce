<?php

    function getCat() {
        global $con;
        $getCat =$con->prepare("SELECT * FROM categories ORDER BY ID DESC ");
        $getCat ->execute();
        $cats =$getCat -> fetchAll();
        return $cats;
    }
    function getItems($where,$value) {
        global $con;
        $getItems =$con->prepare("SELECT * FROM items WHERE $where = ? ORDER BY Item_ID DESC ");
        $getItems->execute(array($value));
        // $getItems ->execute();
        $items =$getItems -> fetchAll();
        return $items;
    }
function chekUserStatus($user){
    global $con;
    $stmtx = $con-> prepare("SELECT userName,RegStatus 
    FROM users WHERE userName=? AND RegStatus = 0
     ");
  $stmtx-> execute (array($user));
  
  $status=$stmtx-> rowCount();
  return $status;
}



function getTitle(){
    global $pageTitle;
    
    if (isset($pageTitle))
    {
        echo $pageTitle;

    }
    else
    {
        echo 'Default';
    }
}


     function redirectHome ($errorMsg,$seconds = 3 )
     {
         echo "<div class='alert alert-danger'>$errorMsg</div>";
         echo"<div class='alert alert-info'>You Will Be redirect $seconds Seconds.</div>";
        header ("refresh:$seconds;url=index.php");
        exit();

     }
//      function checkItem ($select,$form,$value){
//          global $con;
//          $statement =$con -> prepare ("SELECT $select FROM $from WHERE $select =?");
//          $statement->execute(array($value));
//          $count=$statement-> rowCount();
// echo $count;

//      }

        function countItems($item,$table){

            global $con;
                     $stmt2 =$con -> prepare ("SELECT COUNT ($item) FROM $table");
                      $stmt2->execute();
                      return $stmt2-> fetchColumn();
        }
        
        function chekItem($select, $from, $value) {
    
            global $con;
    
            $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    
            $statement->execute(array($value));
    
            $count = $statement->rowCount();
    
            return $count;
    
        }
    
    
    
	function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

		global $con;

		$getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll();

		return $all;

	}