<!--bind parameter :title , :price  so we need to bind it with value by bindValue-->

<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$pdoDB = new PDO("mysql:host=$hostname;dbname=product_crud", $username, $password);
$pdoDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$search = $_GET['search'] ?? '';
if ($search) {
    $statment = $pdoDB->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
    $statment->bindValue(':title', "%$search%");

} else {
    $statment = $pdoDB->prepare('SELECT * FROM products ORDER BY create_date DESC');

}

$statment->execute();
$products = $statment->fetchAll(PDO::FETCH_ASSOC);
//var_dump($products);

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
    <!-- link app css file -->
    <link href="app.css" rel="stylesheet">
    <title>Produts CRUD</title>
</head>
<body style="padding: 10px">
<h1>Produts CRUD</h1>
<div style="padding-bottom: 10px">
    <a href="create.php" class="btn btn-success">Create Products</a>
</div>
<form>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search For Products" name="search"
               value="<?php echo $search ?>">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Button</button>
    </div>
</form>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Title</th>
        <th scope="col">Price</th>
        <th scope="col">Create Date</th>
        <th scope="col">Action</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $i => $product) { ?>
        <tr>
            <th scope="row"><?php echo $i + 1 ?></th>
            <td>
                <img src="<?php echo $product['image'] ?>" class="thumb-image">
            </td>
            <td><?php echo $product['title'] ?></td>
            <td><?php echo $product['price'] ?></td>
            <td><?php echo $product['create_date'] ?></td>
            <td>
                <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-outline-primary">Edit</a>
                <!--the correct way to delete from DB-->
                <form method="post" action="delete.php" style="display: inline-block">
                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </form>
                <!-- this mean that you when click on the button will take you to delete page with id products in database but when you delete smth from DB
                  it will be better to use post so how we can do it -->
                <!-- <a href="delete.php?id= -->
                <?php //echo $products['id'] ?><!--" type="button" class="btn btn-outline-danger">Delete</a>-->
            </td>
            <td></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
