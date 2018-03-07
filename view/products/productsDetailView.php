<main>
    <div class="container">

        <div class="row">
            <!-- LEVI kontejner -->
            <div class="col-md-9">
                <section class="single-product">
                    <div class="row">
                        <div class="col-sm-6">
                            <article>
                                <img class="img-responsive center-block" src="<?php echo $product['image']; ?>" alt=""/>
                            </article>
                        </div>
                        <div class="col-sm-6">
                            <article>
                                <p class="product-title"><?php echo htmlspecialchars($product['title']); ?></p>
                                <p class="price">Cena: <span><?php echo ceil($product['price']); ?>e</span></p>
                                <?php if ($product['discount'] > 0) { ?>
                                    <p class="discount-price">Sok cena: <span><?php echo ceil($product['price'] - $product['price'] * $product['discount'] / 100) ?>e</span></p>
                                <?php } ?>
                            </article>
                            <?php
                            if (!empty($product['description'])) {
                                ?>
                                <article>
                                    <p class="well">
                                        <?php echo htmlspecialchars($product['description']); ?>
                                    </p>
                                </article>
                                <?php
                            }
                            ?>

                            <a style="color: #40b4b3; font-size: 16px; font-weight: bold;" href="/shopping-cart/change-product.php?id=<?php echo $product['id']; ?>&type=increment">Add to cart <span class="fa fa-shopping-cart"></span></a>

                        </div>
                    </div>

                </section>


                <?php require_once __DIR__ . '/listedProductsView.php'; ?>
            </div><!-- kraj levog kontejnera-->


            <!-- ASIDE -->
            <div class="col-md-3 aside">
                <section class="contact ">
                    <h3>Adresa:</h3>
                    <p>Bulevar Mihaila Pupina 181</p>
                    <p>11000 Beograd</p>
                    <p class="phone"><span class="fa fa-phone"></span> 011/123-123</p>
                    <p class="email"><span class="fa fa-envelope-o"></span><a href="mailto:example@mail.com">example@mail.com</a></p>
                    <p class="url"><span class="fa fa-globe"></span><a href="http://school.cubes.rs">school.cubes.rs</a></p>
                </section>
            </div><!-- Kraj aside -->

        </div>
    </div>
</main><!--main end-->
