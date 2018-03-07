        <main>
            <div class="container" style="min-height: 500px;">
                <section class="form-elements">
                    
                    <h1>Login</h1>
                    
                    <span class="error"><?php echo $systemMessage;?></span>
                    
                    <?php
                        if(!$status){
                            ?>
                                <form action="" method="post">
                                    <!--ISKOPIRATI ZA INPUT TEXT-->
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" value="<?php echo isset($formData["username"]) ? htmlspecialchars($formData["username"]) : "";?>">
                                        <?php 
                                                if (isset($formErrors["username"])) {
                                                    foreach($formErrors["username"] as $errorMessage) {
                                                        ?>
                                                        <span class="error"><?php echo $errorMessage;?></span>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>


                                    <!--ISKOPIRATI ZA INPUT PASSWORD-->
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" value="">
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

                                    <!--ISKOPIRATI ZA INPUT TYPE SUBMIT-->
                                    <input type="submit" name="click" value="Login">

                                </form>
                            <?php
                        }
                    ?>
                </section>
            </div>
        </main><!--main end-->