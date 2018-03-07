<main>
    <div class="container">
        <section class="form-elements">

            <h1>Delete product <?php echo $product['title']; ?> photo</h1>
            <img style="width: 200px; height: auto;" src="<?php echo(isset($product['image'])) ? $product['image'] : "/img/no-image.png";?>">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="submit" name="click" value="Delete" style="background-color: red;">
                <input type="submit" name="click" value="Cancel">
            </form>
        </section>
    </div>
</main>