<main>
    <div class="container">
        <section class="include-table">

            <h1>List of categories</h1>
            <a href="/categories/create.php">New Category</a><br><br>
            <?php
            if (!empty($systemMessage)) {
                ?>
                <div class="alert alert-danger" role="alert"><?php echo $systemMessage; ?></div>
                <?php
            }
            ?>

            <?php
            if (count($allCategories) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table  table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($allCategories as $value) {
                                ?>
                                <tr>
                                    <td><img style="width: 50px; height: auto;" src="<?php echo (isset($value['image'])) ? $value['image'] : "/img/no-image.png"; ?>"></td>
                                    <td><?php echo $value['name']; ?></td>
                                    <td>
                                        <?php
                                        if ($value['ban'] == 1) {
                                            echo "Not active";
                                        }
                                        if ($value['ban'] == 0) {
                                            echo "Active";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="/products/category.php?id=<?php echo $value['id']; ?>">View</a>
                                        <a href="/categories/update.php?id=<?php echo $value['id']; ?>">Update</a>
                                        <a href="/categories/delete.php?id=<?php echo $value['id']; ?>">Delete</a>
                                        <a href="/categories/deletePhoto.php?id=<?php echo $value['id']; ?>">Delete photo</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table> 
                </div>
                <?php
            } else {
                echo "There aren't categories";
            }
            ?>
        </section>                
    </div>
</main><!--main end-->