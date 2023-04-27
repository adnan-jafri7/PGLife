<?php
require 'C:\xampp\htdocs\PGLife\includes\database_connect.php';
session_start();


$email = $_POST['email'];
$password = $_POST['password'];
$password = sha1($password);

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	$response = array("success" => false, "message" => "Something went wrong!");
	echo json_encode($response);
	return;
}

$row=mysqli_fetch_assoc($result);
if(empty($row)){
	$response = array("success" => false, "message" => "Wrong username or password!");
	echo json_encode($response);
	return;

}
else{
	$response = array("success" => true, "message" => "You are successfully logged in!");
	echo json_encode($response);
$_SESSION['user_id']=$row['id'];
$_SESSION['full_name']=$row['full_name'];
$_SESSION['email']=$row['email'];
$_SESSION['phone']=$row['phone'];
$_SESSION['college']=$row['college_name'];
return;
}
?>

Click <a href="../index.php">here</a> to continue.
<?php
mysqli_close($conn);
