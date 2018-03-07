<main>
    <div class="container">
        <section class="form-elements">

            <h1>New product</h1>
            
            
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Category name *</label>
                    <input class="form-control" type="text" name="name" value="<?php echo isset($formData["name"]) ? htmlspecialchars($formData["name"]) : "";?>">
                    <?php 
                        if (isset($formErrors["name"])) {
                            foreach($formErrors["name"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label>Category description</label>
                    <textarea class="form-control" name="text"><?php echo isset($formData["text"]) ? htmlspecialchars($formData["text"]) : "";?></textarea>
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
                    <label>Category image</label>
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