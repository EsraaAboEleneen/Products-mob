<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$pdoDB = new PDO("mysql:host=$hostname;dbname=product_crud", $username, $password);
$pdoDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$errors = [];//empty array
$title = '';//when the form loaded the value of label will be empty until you write anything cont.
//to avoid undefined variable $title $price
$price = '';
//check first that the request is post to avoid empty get form error
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['des'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');
    //validation of form
    if (!$title) {
        $errors[] = 'Products Title Is Required';
    }

    if (!$price) {
        $errors[] = 'Products Price Is Required';
    }
    //create image folder which will contain the other random folders
    if (!is_dir('images')) {
        mkdir('images');
    }
    //to avoid that your form add empty row in database
    if (empty($errors)) {
        //check if the user upload if not leave it empty
        //NOTE: ?? operator only used in php 7 there are another semantics changes
        $image = $_FILES['image'] ?? null;
        //make the path null first to enable the $statment defined it as parameter
        $imagePath = '';
        //to avoid adding empty image in database -> ( /image/random dir/... )
        //that happen because even you didn't upload image it still exist empty
        if ($image && $image['tmp_name']) {
            //will create two things-->random folders + image path
            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));//dirname function return the name of directory and leave the other path of image
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        $statement = $pdoDB->prepare("INSERT INTO products(title,description,image,price,create_date) VALUES(:title,:description,:image,:price,:date)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', $date);
        $statement->execute();
        //after creating your new products go back to the crud page
        header('location:crud.php');
        exit();
    }
}
//to male random image path for avoiding overwrite pics when different users upload same image path file
function randomString($n)
{
    $characterSet = '0123456789abcdefghABCDEFGH';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characterSet) - 1);
        $str .= $characterSet[$index];
    }
    return $str;
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Produts CRUD</title>
</head>
<body style="padding: 10px">
<h1>Create new product</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <div><?php echo $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label class="form-label">Product Image</label>
        <br>
        <input type="file" name="image">

    </div>
    <div class="form-group">
        <label class="form-label">Product Title</label>
        <input type="text" class="form-control" name="title" value='<?php echo $title; ?>'>
    </div>
    <div class="form-group">
        <label class="form-label">Product Description</label>
        <textarea class="form-control" name="des"></textarea>
    </div>
    <div class="form-group">
        <label class="form-label">Product Price</label>
        <input type="number" step=".01" name="price" class="form-control" value='<?php echo $price; ?>'>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</body>
</html>