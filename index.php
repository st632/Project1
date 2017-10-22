<?php

/**/

//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);


//instantiate the program object

//Class to load classes it finds the file when the progrm starts to fail for calling a missing class
/*class Manage {
    public static function autoload($class) {
        //you can put any file name or directory here
        include $class . '.php';
    }
}

spl_autoload_register(array('Manage', 'autoload'));*/

//instantiate the program object
$obj = new main();


class main {

    public function __construct()
    {
        //print_r($_REQUEST);
        //set default page request when no parameters are in URL
        $pageRequest = 'homepage';
        //check if there are parameters
        if(isset($_REQUEST['page'])) {
            //load the type of page the request wants into page request
            $pageRequest = $_REQUEST['page'];
        }
        //instantiate the class that is being requested
         $page = new $pageRequest;


        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            $page->get();
        } else {
            $page->post();
        }

    }

}

abstract class page {
    protected $html;

    public function __construct()
    {
        $this->html .= '<html>';
        $this->html .= '<link rel="stylesheet" href="styles.css">';
        $this->html .= '<body>';
    }
    public function __destruct()
    {
        $this->html .= '</body></html>';
        //stringFunctions::printThis($this->html);
    }

    public function get() {
        echo 'default get message';
    }

    public function post() {
        print_r($_POST);
    }
}

class homepage extends page {

    public function get() {
        echo '<html lang="en">';
        echo '<head>';
    //<meta charset="UTF-8">
    //<title>File which is ready to Upload</title>
        echo '</head>';
        echo '<body><form action="index.php?page=homepage" method="post" enctype="multipart/form-data">';
        echo '<h2>Upload File</h2>';
        echo '<label for="fileSelect">Filename:</label>';
        echo '<input type="file" name="photo" id="fileSelect">';
        echo '<input type="submit" name="submit" value="Upload">';
        //<p><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5 MB.</p>
        echo '</form>';
        echo '</body></html>';
        
    }
    public function post() {
        //echo 'test';
        //print_r($_FILES);
        $target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);
// Check if the form was submitted
function uploadmanager()
{
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file that was uploaded without errors
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
                  

                  header("Location:https://web.njit.edu/~st632/Project1/index.php?page=htmlTable&name=$filename");

            }

    } else{
        echo "Error: " . $_FILES["photo"]["error"];
    }
}
}
uploadmanager();


    }
    
    

}

class uploadform extends page
{

    public function get()
    {
        /*$form = '<form action="index2.php?page=uploadform" method="post"
	enctype="multipart/form-data">';
        $form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
        $form .= '<input type="submit" value="Upload Image" name="submit">';
        $form .= '</form> ';
        $this->html .= '<h1>Upload Form</h1>';
        $this->html .= $form;*/

    }

    /*public function post() {
        echo 'test';
        print_r($_FILES);
    }*/
}



class htmlTable extends page {
public function get(){
echo "<html><body><table border=1>\n\n";
$name= "uploads/".$_REQUEST['name'];



$f = fopen($name,"r");
while (($line = fgetcsv($f)) !== false) {
        echo "<tr>";
        foreach ($line as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>\n";
}
fclose($f);
echo "\n</table></body></html>";

}
}



?>