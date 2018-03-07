<main>
    <div class="container">
        <section class="include-table">

            <h1>Shopping cart</h1>

            <?php
            if (!empty($systemMessage)) {
                ?>
                <div class="alert alert-danger" role="alert"><?php echo $systemMessage; ?></div>
                <?php
            }
            ?>

            <?php
            if (count($cart) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table  table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Price with discount</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                                <th class="text-center" style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($cart as $value) {
                                ?>
                                <tr>
                                    <td><img style="width: 100px; height: auto;" src="<?php echo (isset($value['image'])) ? $value['image'] : "/img/no-image.png"; ?>"></td>
                                    <td><?php echo $value['title']; ?></td>
                                    <td class="text-center"><?php echo $value['price']; ?> RSD</td>
                                    <td class="text-center"><?php echo isset($value['discount']) ? $value['discount'] . "%" : "0%"; ?></td>
                                    <td class="text-center">
                                        <?php
                                        if (isset($value['discount'])) {
                                            echo $value['price'] - $value['price'] * $value['discount'] / 100;
                                        } else {
                                            echo $value['price'];
                                        }
                                        ?>
                                        RSD
                                    </td>
                                    <td class="text-center">
                                        <a href="/shopping-cart/change-product.php?id=<?php echo $value['product_id'] ?>&type=decrement"> <span class="fa fa-minus"></span> </a>
                                        <?php echo $value['quantity']; ?>
                                        <a href="/shopping-cart/change-product.php?id=<?php echo $value['product_id'] ?>&type=increment"> <span class="fa fa-plus"></span> </a>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if (isset($value['discount'])) {
                                            $tempPrice = ($value['price'] - $value['price'] * $value['discount'] / 100) * $value['quantity'];
                                        } else {
                                            $tempPrice = $value['price'] * $value['quantity'];
                                        }
                                        echo $tempPrice;

                                        $total += $tempPrice;
                                        ?>
                                        RSD
                                    </td>
                                    <td class="text-center">
                                        <a href="/shopping-cart/change-product.php?id=<?php echo $value['product_id']; ?>&type=remove">Remove</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="8" class="text-right">TOTAL: <?php echo $total . "RSD"; ?></td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
                <div style="padding: 20px;">
                    <a href="/index.php" class="btn btn-default">Continue to shopping</a>
                    <a href="/shopping-cart/checkout.php" class="btn btn-success pull-right">Proceed to checkout</a>
                </div>
                <?php
            } else {
                echo "Shopping cart is empty";
            }
            ?>
        </section>
    </div>
</main><!--main end-->

<style>
    table td a::after {
        content: "";
    }
    .fa-plus{
        margin-left: 10px;
    }
</style>