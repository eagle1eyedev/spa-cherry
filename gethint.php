<?php
require_once('inc/db.php');
session_start();
?>

<?php

$q = $_REQUEST["q"];

if ($q !== "") {
 $query = "SELECT * FROM spa_services LEFT JOIN images ON spa_services.id_image = images.id_image WHERE service_name LIKE '%$q%'";
 $result = mysqli_query($connect,$query);

 while($row = mysqli_fetch_assoc($result)){
  $image = $row['image'];
  echo '<img src="'.$image . '" style="width:150px;height:100px; float:left; display: inline-block; margin:9px;" alt="image">'.'<br/>';
  echo '<br/>';
  echo '<b>' . $row['service_name']. '</b>'.'<br/>';
  echo $row['duration'].' мин.'.'<br/>';
  echo $row['price'].' лв.'.'<br/>';
  echo '<i>Тип: ' . $row['service_type'] . '</i><br/>';
  echo '<br/>';
  echo '<hr/>';
 }
}
else{
  echo 'Няма';
}

?>