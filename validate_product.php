<?php
$title = $_POST['title'];
$description = $_POST['des'];
$price = $_POST['price'];
$imagePath='';

if (!$title) {
    $errors[] = 'Products Title Is Required';
}

if (!$price) {
    $errors[] = 'Products Price Is Required';
}
//__DIR__ refer to the current directory which will be 02_better not products
//__DIR__ from this current directory to .'/public/'.to the imagepath
//if delete or upload or upload the path
if (!is_dir(__DIR__.'/public/images')) {
    mkdir(__DIR__.'/public/images');
}

if (empty($errors)) {

    $image = $_FILES['image'] ?? null;
    $imagePath = __DIR__.'/public/'.$product['image'];

    if ($image && $image['tmp_name']) {
        if ($product['image']) {
            unlink(__DIR__.'/public/'.$product['image']);
        }
        //will create two things-->random folders + image path
        $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
        mkdir(__DIR__.'/public/'.dirname($imagePath));//dirname function return the name of directory and leave the other path of image
        move_uploaded_file($image['tmp_name'], __DIR__.'/public/'.$imagePath);
    }
}