<main>
    <div class="container">
        <section class="form-elements">

            <h1>Update product - <?php echo $product['title'] ?></h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product title *</label>
                    <input class="form-control" type="text" name="title" value="<?php echo isset($formData["title"]) ? htmlspecialchars($formData["title"]) : "";?>">
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
                    <label>Product description</label>
                    <textarea class="form-control" name="description"><?php echo isset($formData["description"]) ? htmlspecialchars($formData["description"]) : "";?></textarea>
                    <?php 
                        if (isset($formErrors["description"])) {
                            foreach($formErrors["description"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <?php
                        if(isset($product['image']) && !empty($product['image'])){
                            ?>
                                <label>Current product image</label><br>
                                <img style="width: 200px; height: auto;" src="<?php echo $product['image'] ?>">
                            <?php
                        }
                    ?>
                    <br>
                    <label>New product image</label>
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
                    <label>Product price *</label>
                    <input class="form-control" type="text" name="price" value="<?php echo isset($formData["price"]) ? htmlspecialchars($formData["price"]) : "";?>">
                    <?php 
                        if (isset($formErrors["price"])) {
                            foreach($formErrors["price"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label>Product category *</label>
                    <select name="category_id" class="form-control">
                        <option value="">--Odaberite kategoriju--</option>
                        <?php
                        foreach ($category_idPossibleValues as $key => $value) {
                            ?>
                                <option value="<?php echo $key; ?>"<?php echo isset($formData["category_id"]) && $formData["category_id"] == $key ? " selected=\"\"" : "";?>><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php 
                        if (isset($formErrors["category_id"])) {
                            foreach($formErrors["category_id"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label>Product sticker</label><br>
                    <?php
                        foreach ($sticker_idPossibleValues as $key => $value) {
                            ?>
                                <label class="radio-inline"><input type="radio" name="sticker_id" value="<?php echo $key; ?>"<?php echo isset($formData["sticker_id"]) && $key == $formData["sticker_id"] ? " checked=\"\"" : "";?>> <?php echo $value; ?><span></span></label>
                            <?php
                        }
                    ?>
                    <?php 
                        if (isset($formErrors["sticker_id"])) {
                            foreach($formErrors["sticker_id"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label>Homepage *</label>
                    <?php
                        foreach ($homepagePossibleValues as $key => $value) {
                            ?>
                                <label  class="radio-inline"><input type="radio" name="homepage" value="<?php echo $key; ?>"<?php echo isset($formData["homepage"]) && $key == $formData["homepage"] ? " checked=\"\"" : "";?>> <?php echo $value; ?> <span></span></label>
                            <?php
                        }
                    ?>
                    <?php 
                        if (isset($formErrors["homepage"])) {
                            foreach($formErrors["homepage"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label>Product discount</label>
                    <input class="form-control" type="text" name="discount" value="<?php echo isset($formData["discount"]) ? htmlspecialchars($formData["discount"]) : "";?>">
                    <?php 
                        if (isset($formErrors["discount"])) {
                            foreach($formErrors["discount"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label>Product quantity *</label>
                    <input class="form-control" type="text" name="quantity" value="<?php echo isset($formData["quantity"]) ? htmlspecialchars($formData["quantity"]) : "";?>">
                    <?php 
                        if (isset($formErrors["quantity"])) {
                            foreach($formErrors["quantity"] as $errorMessage) {
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