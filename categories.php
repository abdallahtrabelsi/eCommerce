<?php

include 'init.php';?>
<div calss="container">
    
    <div class="row">
<?php 
foreach (getItems('Cat_ID',$_GET['pageid']) as $item){
    echo '<div class="col-sm-6 col-md-4">';
    echo '<div class="thumbnail item-box">';
    echo '<span class="price-tag">'.$item['Price'].'$
    </span>';
    echo'<img src="admin/image/'.$item['Image'].'" alt=""/>';
    echo'<div class="caption">';
    echo'<h3>'.$item['Name'].'</h3>';
    echo'<p>'.$item['Description'].'</p>';
    echo '</div>';
    echo '</div>';
}
?>
</div>
</div>
<?php
include $tp1 .'footer.php';
?>