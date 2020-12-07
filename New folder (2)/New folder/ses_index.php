<!DOCTYPE html>
<html>
<body>

<form action="ses_send.php" method="post">
Name: <input type="text" name="name"><br><br>
E-mail: <input type="text" name="email"><br><br>
Phone: <input type="text" name="phone"><br><br>
<input type="submit"><br><br>
</form>

<?php
if($_GET){
    echo $_GET['flag'];       
}
?>


</body>
</html>
