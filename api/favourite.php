<?php
session_start();

require "../includes/database_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "is_logged_in" => false));
    return;
}

$user_id = $_SESSION['user_id'];
$property_id = $_GET["property_id"];
$sql="DELETE from interested_users_properties WHERE user_id='$user_id' AND property_id='$property_id'";
$result=mysqli_query($conn,$sql);
if(!$result){
  echo json_encode(array("success"=>false, "message"=>"$result"));
  return;
  }

else{
  echo json_encode(array("success"=>true,"property_id"=>$property_id));
  return;

}
