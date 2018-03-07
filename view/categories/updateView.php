<main>
    <div class="container">
        <section class="form-elements">

            <h1>Update category - <?php echo $category['name'] ?></h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product name *</label>
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
                    <label>Category text</label>
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
                    <?php
                        if(isset($category['image']) && !empty($category['image'])){
                            ?>
                                <label>Current category image</label><br>
                                <img style="width: 200px; height: auto;" src="<?php echo $category['image'] ?>">
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
                <div class="form-group">
                    <label>Ban status *</label>
                    <?php
                        foreach ($banPossibleValues as $key => $value) {
                            ?>
                                <div class="radio"><label class="radio-inline"><input type="radio" name="ban" value="<?php echo $key; ?>"<?php echo isset($formData["ban"]) && $formData["ban"] == $key ? " checked=\"\"" : "";?>> <?php echo $value; ?><span></span></label></div>
                            <?php
                        }
                    ?>
                </div>
                
                <input type="submit" name="click" value="Save">
            </form>
        </section>
    </div>
</main>