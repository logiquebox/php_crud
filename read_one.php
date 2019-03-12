<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


</head>
<body>


<!-- container -->
<div class="container">

    <div class="page-header">
        <h1 class="text-center">Read Product</h1>
        <hr>
    </div>

    <!-- PHP read one record will be here -->
    <?php
    $id = isset($_GET['id']) ? $_GET['id'] : die("Error!: Record ID NOT Found");
    include "config/database.php";
    try {
        // prepare select query
        $query = "SELECT id, name, description, price FROM products WHERE id = ? LIMIT 0,1";
        $stmt = $con->prepare($query);
        // This is the first record ID
        $stmt->bindParam(1, $id);
        $stmt->execute();
        // Store retrieve record to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Values to fill our form
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
    }
    // show error
    catch (PDOException $exception){
        die("ERROR: ".$exception->getMessage());
    }





    ?>

    <!-- HTML read one record table will be here -->
    <!--we have our html table here where the record will be displayed-->
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td><strong>Name</strong></td>
            <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td><strong>Description</strong></td>
            <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td><strong>Price</strong></td>
            <td><strong>&#36; <?php echo htmlspecialchars($price, ENT_QUOTES);  ?></strong></td>
        </tr>
        <tr>
            <td>
                <a href='index.php' class='btn btn-danger'>Back to read products</a>
            </td>
            <td>
                <a href='#' class='btn btn-primary'>Add to cart</a>
            </td>
        </tr>
    </table>

</div> <!-- end .container -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>