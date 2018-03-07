<main>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <section class="product-wrapper">
                    <h2><?php echo $category['name']; ?></h2>
                    <?php
                        if(isset($category['image']) && !empty($category['image'])){
                            ?>
                                <img style="width: 100%; height: auto;" src="<?php echo $category['image'];?>">
                                <hr>
                            <?php
                        }
                    ?>
                    <?php
                        if(isset($category['text']) && !empty($category['text'])){
                            ?>
                                <p><?php echo $category['text'];?></p>
                                <hr>
                            <?php
                        }
                    ?>
                    <div class="row">
                        
						<?php foreach($products as $product) {?>
                        <!-- Ovo je sve jedan proizvod -->
                        <div class="col-sm-6 col-md-4">
                            <article class="product">
								<?php if ($product['sticker_title']) {?>
                                <span class="sticker">
                                    <img src="/img/stickers/<?php echo strtolower($product['sticker_title']);?>.png" alt="<?php echo htmlspecialchars($product['sticker_title']);?>"/>
                                </span>
								<?php }?>
                                <figure>
                                    <img src="<?php echo (isset($product['image'])) ? $product['image']: "/img/no-image.png"; ?>" alt="<?php echo htmlspecialchars($product['title']);?>"/>
                                </figure>
                                <p class="product-title"><?php echo htmlspecialchars($product['title']);?></p>
                                <div class="product-price">
                                    <p class="price ">Cena: <span><?php echo ceil($product['price']);?>e</span></p>
                                    <?php if ($product['discount'] > 0) {?>
									<p class="discount-price">Sok cena: <span><?php echo ceil($product['price'] - $product['price'] * $product['discount'] / 100)?>e</span></p>
									<?php }?>
                                </div>
                                <a href="/products/detail.php?id=<?php echo $product['id'];?>" class="more">Detail</a>
                                <a href="/shopping-cart/change-product.php?id=<?php echo $product['id'];?>&type=increment"><span class="fa fa-shopping-cart"></span></a>
                            </article>
                        </div><!--Kraj proizvoda-->
						<?php }?>
                    </div>
                </section>
                
                 <!-- PAGINATION START -->
                <?php require_once __DIR__ . '/../partial/paginationView.php';?>
                <!-- PAGINATION END -->
                
                
				<?php require_once __DIR__ . '/listedProductsView.php';?>
            </div>
            <div class="col-md-3 aside">
                <section class="contact ">
                    <h3>Adresa:</h3>
                    <p>Bulevar Mihaila Pupina 181</p>
                    <p>11000 Beograd</p>
                    <p class="phone"><span class="fa fa-phone"></span> 011/123-123</p>
                    <p class="email"><span class="fa fa-envelope-o"></span><a href="mailto:example@mail.com">example@mail.com</a></p>
                    <p class="url"><span class="fa fa-globe"></span><a href="http://school.cubes.rs">school.cubes.rs</a></p>
                </section>
            </div>
        </div>
    </div>
</main>
