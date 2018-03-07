<main>
    <div class="container">
        <section class="form-elements">

            <h1>New Order</h1>
            <form action="" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="" class="form-control">
                </div>

                <?php
                if (isset($formErrors["name"])) {
                    foreach ($formErrors["name"] as $errorMessage) {
                        ?>
                        <span class="error"><?php echo $errorMessage; ?></span>
                        <?php
                    }
                }
                ?>


                <div class="form-group">
                    <label>Surname</label>
                    <input type="text" name="surname" value="" class="form-control">
                </div>

                <?php
                if (isset($formErrors["surname"])) {
                    foreach ($formErrors["surname"] as $errorMessage) {
                        ?>
                        <span class="error"><?php echo $errorMessage; ?></span>
                        <?php
                    }
                }
                ?>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" value="" class="form-control">
                </div>

                <?php
                if (isset($formErrors["email"])) {
                    foreach ($formErrors["email"] as $errorMessage) {
                        ?>
                        <span class="error"><?php echo $errorMessage; ?></span>
                        <?php
                    }
                }
                ?>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="" class="form-control">
                </div>

                <?php
                if (isset($formErrors["phone"])) {
                    foreach ($formErrors["phone"] as $errorMessage) {
                        ?>
                        <span class="error"><?php echo $errorMessage; ?></span>
                        <?php
                    }
                }
                ?>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" value="" class="form-control">
                </div>

                <?php
                if (isset($formErrors["address"])) {
                    foreach ($formErrors["address"] as $errorMessage) {
                        ?>
                        <span class="error"><?php echo $errorMessage; ?></span>
                        <?php
                    }
                }
                ?>




                <input type="submit" name="click" value="Finish Order">
            </form>
        </section>
    </div>
</main>

