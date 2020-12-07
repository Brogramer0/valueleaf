<?php
session_start();
if(!isset($_SESSION["username"])){
header("Location: login.php");
exit(); }
$username = $_SESSION["username"];
require('db.php');
$id = $_SESSION["id"];
$conn = mysqli_connect("localhost","root","12345Tyuio","mydb") or die("Connection Error: " . mysqli_error($conn));

if (count($_POST) > 0) {
    $result = mysqli_query($conn, "SELECT *from users WHERE id='$id'");
    $row = mysqli_fetch_array($result);
    
    if (md5($_POST["currentPassword"]) == $row["password"]) {
        mysqli_query($conn, "UPDATE users set password='" . md5($_POST["newPassword"]) . "' WHERE id='$id'");
        $message = "Password Changed";
        header("Location:index.php");
    } else
        $message = "Current Password is not correct";
}
?>
<html>
<head>
<title>Change Password</title>
<link rel="stylesheet" href="css/style.css" />
<script>
function validatePassword() {
var currentPassword,newPassword,confirmPassword,output = true;

currentPassword = document.frmChange.currentPassword;
newPassword = document.frmChange.newPassword;
confirmPassword = document.frmChange.confirmPassword;

if(!currentPassword.value) {
	currentPassword.focus();
	document.getElementById("currentPassword").innerHTML = "required";
	output = false;
}
else if(!newPassword.value) {
	newPassword.focus();
	document.getElementById("newPassword").innerHTML = "required";
	output = false;
}
else if(!confirmPassword.value) {
	confirmPassword.focus();
	document.getElementById("confirmPassword").innerHTML = "required";
	output = false;
}
if(newPassword.value != confirmPassword.value) {
	newPassword.value="";
	confirmPassword.value="";
	newPassword.focus();
	document.getElementById("confirmPassword").innerHTML = "not same";
	output = false;
} 	
return output;
}
</script>
</head>
<body>
    <div class="form">
        
        <h2>Change Password</h2>
        <form name="frmChange" method="post" action="change_password.php" onSubmit="return validatePassword()">
            
            <div class="error"><?php if(isset($message)) { echo $message; } ?></div>
            <table>
                
                <tr>
                    <td ><label>Current Password</label></td>
                    <td ><input type="password" name="currentPassword" class="txtField" /><span id="currentPassword" class="error"></span></td>
                </tr>
                <tr>
                    <td><label>New Password</label></td>
                    <td><input type="password" name="newPassword" class="txtField" /><span id="newPassword" class="error"></span></td>
                </tr>
                    <td><label>Confirm Password</label></td>
                    <td><input type="password" name="confirmPassword" class="txtField" /><span id="confirmPassword" class="error"></span></td>
                </tr>
               
            </table>
            <input type="submit" name="submit" value="Submit" class="form">
        </form>
    </div>
</body>
</html>