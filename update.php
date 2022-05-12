<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$pdoDB = new PDO("mysql:host=$hostname;dbname=product_crud", $username, $password);
$pdoDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//get method
$id = $_GET['id'] ?? null;
if (!$id) {
    header('location:crud.php');
    exit();
}
//the update code..........
$statement = $pdoDB->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);
//var_dump($products);
$errors = [];
$title = $product['title'];//to show the products name in the label to know the products info
$price = $product['price'];
$description = $product['description'];

//same process in update as create with little changes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['des'];
    $price = $_POST['price'];

    if (!$title) {
        $errors[] = 'Products Title Is Required';
    }

    if (!$price) {
        $errors[] = 'Products Price Is Required';
    }

    if (!is_dir('images')) {
        mkdir('images');
    }

    if (empty($errors)) {

        $image = $_FILES['image'] ?? null;
        //we should put the image path the same path of selected image from DB
        $imagePath = $product['image'];

        if ($image && $image['tmp_name']) {
            //check if image is uploaded it will delete the old one and update with new one
            //if the user didn't change the products image it will remain the same without delete it
            if ($product['image']) {
                unlink($product['image']);
            }
            //will create two things-->random folders + image path
            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));//dirname function return the name of directory and leave the other path of image
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        $statement = $pdoDB->prepare("UPDATE products SET title= :title, description= :description, image=:image,price=:price WHERE id=:id");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':id', $id);
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
    <link href="app.css" rel="stylesheet">


    <title>Produts CRUD</title>
</head>
<body style="padding: 10px">
<p>
    <a href="crud.php" class="btn btn-secondary">Go Back To Products</a>
</p>
<h1>Update product <?php echo $product['title'] ?></h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <div><?php echo $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="" enctype="multipart/form-data">
    <!-- to display the image which will be changed -->
    <?php if ($product['image']): ?>
        <img src="<?php echo $product['image'] ?>" class="update-image">
    <?php endif; ?>
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
