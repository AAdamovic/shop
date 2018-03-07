<main>
    <div class="container">
        <section class="form-elements">

            <h1>Edit user - <?php echo $user['name'] . ' ' . $user['surname']; ?></h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Name *</label>
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
                    <label>Surname *</label>
                    <input class="form-control" type="text" name="surname" value="<?php echo isset($formData["surname"]) ? htmlspecialchars($formData["surname"]) : "";?>">
                    <?php 
                        if (isset($formErrors["surname"])) {
                            foreach($formErrors["surname"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>

                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input disabled class="form-control" type="text" name="email" value="<?php echo isset($formData["email"]) ? htmlspecialchars($formData["email"]) : "";?>">
                    <?php 
                        if (isset($formErrors["email"])) {
                            foreach($formErrors["email"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label>New password (insert this field only if you want to change old password)</label>
                    <input class="form-control" type="password" name="password" value="">
                    <?php 
                        if (isset($formErrors["password"])) {
                            foreach($formErrors["password"] as $errorMessage) {
                                ?>
                                    <span class="error"><?php echo $errorMessage;?></span>
                                <?php
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label>Repaet password  (insert this field only if you want to change old password)</label>
                    <input class="form-control" type="password" name="repeat-password" value="">
                    <?php 
                        if (isset($formErrors["repeat-password"])) {
                            foreach($formErrors["repeat-password"] as $errorMessage) {
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