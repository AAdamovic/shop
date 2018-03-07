<main>
    <div class="container">
        <section class="form-elements">

            <h1>Delete category <?php echo $category['name']; ?> photo  </h1>
            <img style="width: 200px; height: 150;" src="<?php echo(isset($category['image'])) ? $category['image'] : "/img/no-image.png";?>">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="submit" name="click" value="Delete" style="background-color: red;">
                <input type="submit" name="click" value="Cancel">
            </form>
        </section>
    </div>
</main>
