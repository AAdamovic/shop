<main>
    <div class="container">

        <div class="row">
            <!-- LEVI kontejner -->
            <div class="col-md-9">
                <section class="single-product">
                    <div class="row">
                        <div class="col-sm-6">
                            <article>
                                <img class="img-responsive center-block" src="<?php echo $page['image']; ?>" alt=""/>
                            </article>
                        </div>
                        <div class="col-sm-6">
                            <article>
                                <p class="product-title"><?php echo htmlspecialchars($page['title']); ?></p>

                            </article>
                            <?php
                            if (!empty($page['text'])) {
                                ?>
                                <article>
                                    <p class="well">
                                        <?php echo htmlspecialchars($page['text']); ?>
                                    </p>
                                </article>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                </section>
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
</main>