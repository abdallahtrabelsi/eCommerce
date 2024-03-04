<?php
    function getCat() {
        global $con;
        $getCat =$con->prepare("SELECT * FROM categories ORDER BY ID DESC ");
        $getCat ->execute();
        $cats =$getCat -> fetchAll();
        return $cats;
    }


function countItems($item,$table){
    global $con ;
    $stmt2 =$con ->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}

function getTitle(){
    global $pageTitle;
    if (isset ($pageTitle)){
        echo $pageTitle;

    }
    else{
        echo 'Default';
    }
}
function redirectHome($errorMsg,$seconds = 3 ){
    echo "<div class='alert alert-danger'>$errorMsg</div>";
    echo "<div class='alert alert-info'>You will be redirect to Homepage after $seconds Seconds !!!</div>";
    header("refresh: $seconds; url=index.php");
    exit();
}
function chekItem($select,$from,$value){
    global $con;
    $statement =$con -> prepare("SELECT $select FROM $from WHERE $select =?");
    $statement->execute (array($value));
    $count =$statement->rowCount();
    return $count;
}

function getLatest($select,$table,$order,$limit=5){
    global $con;
    $getStmt=$con->prepare ("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows=$getStmt->fetchAll();
    return $rows;
}
function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

    global $con;

    $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

    $getAll->execute();

    $all = $getAll->fetchAll();

    return $all;

}