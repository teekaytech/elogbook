<?php
if (isset($_POST['submit'])) {
    
    $name = $_FILES['file']['name'];
    //$size = $_FILES['file']['size'];
    //$type = $_FILES['file']['type'];
    $tmp_name = $_FILES['file']['tmp_name'];
    //$error = $_FILES['file']['error'];
    
    if (!empty($name)) {
        $location = '../std_upld/';
        if (move_uploaded_file($tmp_name, $location.$name)) { echo "Upload successful!"; }
        else { echo "There was an error!"; }
    } else {
        echo "Please, choose a file";
    }
    
}
?>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file"><br>
    <input type="submit" value="upload" name="submit">
</form>
