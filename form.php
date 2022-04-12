<!--now we need to define $products and $title and others-->
<form method="post" action="" enctype="multipart/form-data">
    <!-- to display the image which will be changed -->
    <?php if ($product['image']): ?>
        <img src="/<?php echo $product['image'] ?>" class="update-image">
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