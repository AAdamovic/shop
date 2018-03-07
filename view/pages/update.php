<main>
    <div class="container">
        <section class="form-elements">

            <h1>Update category - <?php echo $page['title'] ?></h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product title *</label>
                    <input class="form-control" type="text" name="title" value="<?php echo isset($page["title"]) ? htmlspecialchars($page["title"]) : "";?>">
                    <?php 
                        if (isset($formErrors["title"])) {
                            foreach($formErrors["title"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label>Category text</label>
                    <textarea class="form-control" name="text"><?php echo isset($page["text"]) ? htmlspecialchars($page["text"]) : "";?></textarea>
                    <?php 
                        if (isset($formErrors["text"])) {
                            foreach($formErrors["text"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <?php
                        if(isset($page['image']) && !empty($page['image'])){
                            ?>
                                <label>Current category image</label><br>
                                <img style="width: 200px; height: auto;" src="<?php echo $page['image'] ?>">
                            <?php
                        }
                    ?>
                    <br>
                    <label>New category image</label>
                    <input class="form-control" type="file" name="image" style="border: none; box-shadow: none;">
                    <?php 
                        if (isset($formErrors["image"])) {
                            foreach($formErrors["image"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                
                
                <input type="submit" name="click" value="Save">
            </form>
        </section>
    </div>
</main>

