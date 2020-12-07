<!DOCTYPE html>
<html>
<meta charset="utf-8">
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
        <?php
        session_start();
        if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit(); }
        $username = $_SESSION["username"];
        require('db.php');
        $id = $_SESSION["id"];
        $query = "select * from users where id = '$id';";
        $result = mysqli_query($con,$query);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                
                $old_name = $row["username"];
                $old_email = $row["email"];
                $old_phone = $row["phone"];
            }
        }
        // If form submitted, insert values into the database.
        if (isset($_REQUEST['username'])){
                // removes backslashes
                $username = stripslashes($_REQUEST['username']);
                //escapes special characters in a string
                $username = mysqli_real_escape_string($con,$username); 
                $email = stripslashes($_REQUEST['email']);
                $email = mysqli_real_escape_string($con,$email);
                $phone = stripslashes($_REQUEST['phone']);
                $phone = mysqli_real_escape_string($con,$phone);
                $query = " UPDATE users SET username = '$username', email = '$email', phone = '$phone' where id = '$id'";
                $result = mysqli_query($con,$query);
                if($result){
                    $_SESSION['username'] = $username;
                    header("Location:index.php");
                }
        }else{
        ?>
        <div class="form">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <h2>Edit Profile</h2>
                <form name="registration" action="edit.php" method="post">
                        <table class="mid" >
                                <tr>
                                        <td>User Name : </th>
                                        <td><input type="text" name="username" placeholder="Username" value="<?php echo $old_name; ?>" required /></th>
                                </tr>
                                <tr>
                                        <td>E-mail : </td>
                                        <td><input type="email" name="email" placeholder="E-mail" value="<?php echo $old_email; ?>" required /></td>
                                </tr>
                                <tr>
                                        <td>Phone</td>
                                        <td><input type="phone" name="phone" placeholder="Phone" value="<?php echo $old_phone; ?>" required /></td>
                                </tr>
                        </table>
                        <input class = "form" type="submit" name="submit" value="Apply Changes" />
                </form>
        </div>

        <?php } ?>

</body>
</html>
