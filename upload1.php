<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);
// Check if the form was submitted
function uploadmanager()
{
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
        $allowed = array("csv");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];



        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");



            // Check whether file exists before uploading it
            if(file_exists("upload/" . $_FILES["photo"]["name"])){
                echo $_FILES["photo"]["name"] . " is already exists.";
            } else{
               // echo "https://web.njit.edu/~st632/public_html/uploads/" . $_FILES["photo"]["name"];
                echo "\n"; 
                move_uploaded_file($_FILES["photo"]["tmp_name"],"uploads/" . $_FILES["photo"]["name"]);
                echo "Your file was uploaded successfully.";
                  

                  header("Location:https://web.njit.edu/~st632/Project1/display.php?name=$filename");

            }

    } else{
        echo "Error: " . $_FILES["photo"]["error"];
    }
}
}
uploadmanager();
?>
