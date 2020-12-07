<!DOCTYPE html>
<html>
<meta charset="utf-8">
<link rel="stylesheet" href="css/style.css" />

</head>
<body>
        <?php
        require('db.php');
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
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($con,$password);
                $con_password = stripslashes($_REQUEST['confirm_password']);
                $con_password = mysqli_real_escape_string($con,$con_password);
                $trn_date = date("Y-m-d H:i:s");
                
                $query = "INSERT into `users` (username, password, email, trn_date, phone)
        VALUES ('$username', '".md5($password)."', '$email', '$trn_date', '$phone')";
                $result = mysqli_query($con,$query);

                if($result){
                        header("Location:index.php");
                }
        }else{
        ?>
        <div class="form">
                <h1>Registration</h1>
                <form name="registration" action="" method="post">
                        <input type="text" name="username" placeholder="Username" required />
                        <input type="phone" name="phone" placeholder="Phone" required />
                        <input type="email" name="email" placeholder="E-mail"  required />
                        <input type="password" name="password" placeholder="Password"  id="password" required />
                        <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" required />
                        <input type="submit" name="submit" value="Register" />
                </form>
        </div>
        <script>
                var password = document.getElementById("password")
                , confirm_password = document.getElementById("confirm_password");

                function validatePassword(){
                        if(password.value != confirm_password.value) {
                                confirm_password.setCustomValidity("Passwords Don't Match");
                        }
                        else {
                                confirm_password.setCustomValidity('');
                        }

                }

                password.onchange = validatePassword;
                confirm_password.onchange = validatePassword;
        </script>

        <?php } ?>

</body>
</html>
