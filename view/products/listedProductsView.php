				<?php if (!empty($_SESSION['listed_products'])) {?>
				<section class="last-watched-products">
                    <h2>Pregledani proizvodi</h2>
                    <div class="row">
						<?php 
						
						foreach ($_SESSION['listed_products'] as $id) {
							$product = getProduct($id, $connection);
							
							if (!$product) {
								continue;
							}
							
						?>
                        <div class="col-xs-6 col-sm-3 col-lg-2">
                            <article class="product">
                                <?php if ($product['sticker_title']) {?>
                                <span class="sticker">
                                    <img src="/img/stickers/<?php echo strtolower($product['sticker_title']);?>.png" alt="<?php echo htmlspecialchars($product['sticker_title']);?>"/>
                                </span>
								<?php }?>
                                <figure>
                                    <img src="<?php echo $product['image'];?>" alt=""/>
                                </figure>
                                <p class="product-title"><?php echo htmlspecialchars($product['title']);?></p>
                                <a href="/products/detail.php?id=<?php echo $product['id'];?>" class="more">Detail</a>
                            </article>
                        </div>
						<?php }?>
                    </div>
                </section>
				<?php }?>