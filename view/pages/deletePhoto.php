<main>
    <div class="container">
        <section class="form-elements">

            <h1>Delete page photo- <?php echo $page['title']; ?></h1>
            <img style="width: 200px; height: 150;" src="<?php echo(isset($page['image'])) ? $page['image'] : "/img/no-image.png";?>">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="submit" name="click" value="Delete" style="background-color: red;">
                <input type="submit" name="click" value="Cancel">
            </form>
        </section>
    </div>
</main>



