<!DOCTYPE html>
<html>
<body>

<form action="upload-to-s3.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload File" name="submit">
</form>

<?php
if($_GET){
    echo $_GET['send'];       
}
?>


</body>
</html>

