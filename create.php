<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
<div class="container col-lg-6">
    <div class="page-header mb-5">
        <h1 class="text-center">Create Product</h1>
    </div>
<!--html form to create product will be here -->
<!--php insert Code will go here     -->
    <?php
    if($_POST){
        include "config/database.php";
        try {
            // insert query
            $query = "INSERT INTO products
            SET name=:name, description=:description,
                price=:price, image=:image, created=:created";

            // prepare query for execution
            $stmt = $con->prepare($query);

            $name=htmlspecialchars(strip_tags($_POST['name']));
            $description=htmlspecialchars(strip_tags($_POST['description']));
            $price=htmlspecialchars(strip_tags($_POST['price']));

            // new 'image' field
            $image=!empty($_FILES["image"]["name"])
                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                : "";
            $image=htmlspecialchars(strip_tags($image));

            // bind the parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image', $image);

            // specify when this record was inserted to the database
            $created=date('Y-m-d H:i:s');
            $stmt->bindParam(':created', $created);

            // Execute the query
            if($stmt->execute()){
                echo "<div class='alert alert-success'>Record was saved.</div>";
                // now, if image is not empty, try to upload the image
                if($image){

                    // sha1_file() function is used to make a unique file name
                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                    // error message is empty
                    $file_upload_error_messages="";
                    // make sure that file is a real image
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if($check!==false){
                        // submitted file is an image
                    }else{
                        $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
                    }

                    // make sure certain file types are allowed
                    $allowed_file_types=array("jpg", "jpeg", "png", "gif");
                    if(!in_array($file_type, $allowed_file_types)){
                        $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                    }
                    // make sure file does not exist
                    if(file_exists($target_file)){
                        $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
                    }
                    // make sure submitted file is not too large, can't be larger than 1 MB
                    if($_FILES['image']['size'] > (1024000)){
                        $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
                    }
                    // make sure the 'uploads' folder exists
                    // if not, create it
                    if(!is_dir($target_directory)){
                        mkdir($target_directory, 0777, true);
                    }
                    // if $file_upload_error_messages is still empty
                    if(empty($file_upload_error_messages)){
                        // it means there are no errors, so try to upload the file
                        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                            // it means photo was uploaded
                        }else{
                            echo "<div class='alert alert-danger'>";
                            echo "<div>Unable to upload photo.</div>";
                            echo "<div>Update the record to upload photo.</div>";
                            echo "</div>";
                        }
                    }

                        // if $file_upload_error_messages is NOT empty
                    else{
                        // it means there are some errors, so show them to user
                        echo "<div class='alert alert-danger'>";
                        echo "<div>{$file_upload_error_messages}</div>";
                        echo "<div>Update the record to upload photo.</div>";
                        echo "</div>";
                    }

                }
            }else{
                echo "<div class='alert alert-danger'>Unable to save record.</div>";
            }

        }

            // show error
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <table class="table table-hover table-responsive table-bordered">
            <tr>
                <td>Name</td>
                <td><input type='text' name='name' class='form-control'></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><textarea type="text" name="description" class="form-control d-block"></textarea></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><input type="text" name="price" class="form-control"></td>
            </tr>
            <tr>
                <td>Photo</td>
                <td><input type="file" name="image" /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='index.php' class='btn btn-danger'>Back to read products</a>
                </td>
            </tr>
        </table>
    </form>

</div> <!--end of container div-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>