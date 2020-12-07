<?php
session_start();

if(!isset($_SESSION["username"])){
header("Location: login.php");
exit(); }
?>
<!DOCTYPE html>
<meta charset="utf-8">
<title>Deactivate</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div class='form'>
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <h2>Are you sure?</h2>
    <form method="post" action="delete.php"> 
        <input class='form' type="submit" name="deactivate" value="Deactivate" /> 
    </form>
    <div> 
    
    <?php
    if(array_key_exists('deactivate', $_POST)) { 
        require('db.php');
        $id = $_SESSION["id"];
        
        $username = $_SESSION["username"];

        $query1 = "UPDATE users
                SET active = FALSE
                WHERE
                    id = '$id';";
        $result1 = mysqli_query($con,$query1);
        header("Location: login.php");
    }  
    ?>
</body>
</html>