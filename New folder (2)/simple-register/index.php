<?php
session_start();
if(!isset($_SESSION["username"])){
header("Location: login.php");
exit(); }
require('db.php');
?>
<!DOCTYPE html>
<meta charset="utf-8">
<title>Welcome</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <h2>User Details:</h2>

    <?php
    require('db.php');
    $username = $_SESSION["username"];
    $id = $_SESSION['id'];
    $query = "select * from users where username = '$username';";
        $result = mysqli_query($con,$query);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $name = $row["username"];
                $email = $row["email"];
                $phone = $row["phone"];
                if($row["active"] == TRUE){
                    $status = "active";
                }
                else{
                    $status = "Decativated";
                }
                
            }
            ?>
            <table>
                <tr>
                    <th>UserName</th>
                    <th>E-mail</th>
                    <th>Phone No.</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $phone; ?></td>
                    <td><?php echo $status; ?></td>
                    <td><a><button class="button1" onclick="edit_user()">Edit</button></a> 
                        <a><button type="button" class="button1" onclick="delete_user()">Delete</button></a>
                        <a href="change_password.php"><button type="button" class="button1" >Change Password</button></a>
                    </td>
                </tr>
            </table>
            <p id="demo"></p>
            <script>
                function edit_user() {
                var xhttp;
                if (window.XMLHttpRequest) {
                    // code for modern browsers
                    xhttp = new XMLHttpRequest();
                    } else {
                    // code for IE6, IE5
                    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("demo").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "edit.php", true);
                xhttp.send();
                }

                function delete_user() {
                var xhttp;
                if (window.XMLHttpRequest) {
                    // code for modern browsers
                    xhttp = new XMLHttpRequest();
                    } else {
                    // code for IE6, IE5
                    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("demo").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "delete.php", true);
                xhttp.send();
                }
            </script>
        <?php 
        }
        ?>


    <a href="logout.php">Logout</a>
</body>
</html>