<main>
    <div class="container">
        <section class="include-table">

            <h1>List of products</h1>
            <a href="/products/create.php">New product</a><br><br>
            <?php
            if (!empty($systemMessage)) {
                ?>
                <div class="alert alert-danger" role="alert"><?php echo $systemMessage; ?></div>
                <?php
            }
            ?>

            <?php
            if (count($products) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table  table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>
                                    Title
                                    <a style="color: white; margin-left: 10px;" href="/products/list.php?order=title_asc"><span class="fa fa-arrow-up"><!--POMERI ME GORE--></span></a>
                                    <a style="color: white; margin-left: 10px;" href="/products/list.php?order=title_desc"><span class="fa fa-arrow-down"><!--POMERI ME DOLE--></span></a>
                                </th>
                                <th>
                                    Category
                                    <a style="color: white; margin-left: 10px;" href="/products/list.php?order=category_asc"><span class="fa fa-arrow-up"><!--POMERI ME GORE--></span></a>
                                    <a style="color: white; margin-left: 10px;" href="/products/list.php?order=category_desc"><span class="fa fa-arrow-down"><!--POMERI ME DOLE--></span></a>
                                </th>
                                <th>
                                    Sticker
                                    <a style="color: white; margin-left: 10px;" href="/products/list.php?order=sticker_asc"><span class="fa fa-arrow-up"><!--POMERI ME GORE--></span></a>
                                    <a style="color: white; margin-left: 10px;" href="/products/list.php?order=sticker_desc"><span class="fa fa-arrow-down"><!--POMERI ME DOLE--></span></a>
                                </th>
                                <th class="text-center">
                                    Price
                                    <a style="color: white; margin-left: 10px;" href="/products/list.php?order=price_asc"><span class="fa fa-arrow-up"><!--POMERI ME GORE--></span></a>
                                    <a style="color: white; margin-left: 10px;" href="/products/list.php?order=price_desc"><span class="fa fa-arrow-down"><!--POMERI ME DOLE--></span></a>
                                </th>
                                <th class="text-center">
                                    Discount
                                    <a style="color: white; margin-left: 10px;" href="/products/list.php?order=discount_asc"><span class="fa fa-arrow-up"><!--POMERI ME GORE--></span></a>
                                    <a style="color: white; margin-left: 10px;" href="/products/list.php?order=discount_desc"><span class="fa fa-arrow-down"><!--POMERI ME DOLE--></span></a>
                                </th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center" style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($products as $value) {
                                ?>
                                <tr>
                                    <td><img style="width: 100px; height: auto;" src="<?php echo (isset($value['image'])) ? $value['image'] : "/img/no-image.png"; ?>"></td>
                                    <td><?php echo $value['title']; ?></td>
                                    <td><?php echo $value['category_name']; ?></td>
                                    <td>
                                        <?php
                                        if (isset($value['sticker_title'])) {
                                            ?>
                                            <img style="width: 50px; height: auto;" src="/img/stickers/<?php echo$value['sticker_title']; ?>.png">
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?php echo $value['price']; ?></td>
                                    <td class="text-center"><?php echo isset($value['discount']) ? $value['discount'] . "%" : ""; ?></td>
                                    <td class="text-center"><?php echo $value['quantity']; ?></td>
                                    <td class="text-center">
                                        <a href="/products/detail.php?id=<?php echo $value['id']; ?>">Details</a>
                                        <a href="/products/update.php?id=<?php echo $value['id']; ?>">Update</a>
                                        <a href="/products/delete.php?id=<?php echo $value['id']; ?>">Delete</a>
                                        <a href="/products/deletePhoto.php?id=<?php echo $value['id']; ?>">Delete photo</a>
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
                echo "Nema unsesenih proizvoda";
            }
            ?>
        </section>

        <!-- PAGINATION START -->
        <?php require_once __DIR__ . '/../partial/paginationView.php'; ?>
        <!-- PAGINATION END -->


    </div>
</main><!--main end-->