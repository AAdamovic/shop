<main>
    <div class="container">
        <section class="form-elements">
            
            <h1>Page</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Page title *</label>
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
                    <label>Page Text</label>
                    <textarea class="form-control" name="pageText"><?php echo isset($formData["pageText"]) ? htmlspecialchars($formData["pageText"]) : "";?></textarea>
                    <?php 
                        if (isset($formErrors["pageText"])) {
                            foreach($formErrors["pageText"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label>Page image</label>
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
