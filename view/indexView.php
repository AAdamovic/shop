<main>
    <div class="container">

        <section class="product-wrapper">
            <h2>Proizvodi</h2>
            <div class="row">

                <?php foreach ($products as $product) { ?>
                    <!-- Ovo je sve jedan proizvod -->
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <article class="product">
                            <?php if ($product['sticker_title']) { ?>
                                <span class="sticker">
                                    <img src="/img/stickers/<?php echo strtolower($product['sticker_title']); ?>.png" alt="<?php echo htmlspecialchars($product['sticker_title']); ?>"/>
                                </span>
                            <?php } ?>
                            <figure>
                                <img src="<?php echo (isset($product['image'])) ? $product['image'] : "/img/no-image.png"; ?>" alt="<?php echo htmlspecialchars($product['title']); ?>"/>
                            </figure>
                            <p class="product-title"><?php echo htmlspecialchars($product['title']); ?></p>
                            <div class="product-price">
                                <p class="price ">Cena: <span><?php echo ceil($product['price']). " din"; ?></span></p>
                                <?php if ($product['discount'] > 0) { ?>
                                    <p class="discount-price">Sok cena: <span><?php echo ceil($product['price'] - $product['price'] * $product['discount'] / 100) . " din" ?></span></p>
                                <?php } ?>
                            </div>
                            <a href="/products/detail.php?id=<?php echo $product['id']; ?>" class="more">Detail</a>
                            <a href="/shopping-cart/change-product.php?id=<?php echo $product['id']; ?>&type=increment"><span class="fa fa-shopping-cart"></span></a>
                        </article>
                    </div><!--Kraj proizvoda-->
                <?php } ?>
            </div>
        </section>

        <!-- PAGINATION START -->
        <?php require_once __DIR__ . '/partial/paginationView.php'; ?>
        <!-- PAGINATION END -->


        <?php require_once __DIR__ . '/products/listedProductsView.php'; ?>


    </div>
</main><!--main end-->


