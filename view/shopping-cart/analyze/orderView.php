
<main>
    
    <div class="container">
        <section class="include-table">

            <h1>Orders</h1> <br>
            <form action="" method="get" >

                <div class="form-group">
                    <label>Filter by product</label><br>
                    <input type="text" name="search" value="<?php echo isset($formData["search"]) ? htmlspecialchars($formData["search"]) : ""; ?>">
                    <?php
                    if (isset($formErrors["search"])) {
                        foreach ($formErrors["search"] as $errorMessage) {
                            ?>
                            <span class="error"><?php echo $errorMessage; ?></span>
                            <?php
                        }
                    }
                    ?>

                </div>

                <input type="submit" name="click" value="Search">
            </form>

            <div class="table-responsive">
                <table class="table  table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Products</th>
                            <th>AKCIJA</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($orders as $order) {
                        ?>  

                        <tbody>
                            <tr>
                                <td><span>Datum: <?php echo $order['date_created']; ?></span> <br>
                                    <span>Ime: <?php echo $order['name']; ?></span> <br>
                                    <span>Prezime: <?php echo $order['surname']; ?></span> <br>
                                    <span>Telefon: <?php echo $order['phone']; ?></span> <br>
                                    <span>Adresa: <?php echo $order['address']; ?></span> <br>
                                </td>

                                <td>
                                    <?php
                                    foreach ($ordersAndProducts[$order['id']] as $value) {
                                        ?>
                                        <span>Naziv: <?php echo $value['title']; ?>  </span> <br>
                                        <span>Cena: <?php echo $value['price']; ?> rsd  </span> <br>
                                        <?php
                                        if ($value['discount'] != NULL) {
                                            ?>
                                            <span>Popust: <?php echo $value['discount']; ?>  </span> <br>
                                            <?php
                                        }
                                        ?>
                                        <span>Kolicina: <?php echo $value['quantity']; ?>  </span>  <br>
                                        ----------------------------------------------- <br>
                                        <?php
                                    }
                                    ?>
                                </td> 

                                <td>
                                    <a href="#">DETALJNIJE</a>
                                    <a href="#">IZMENI</a>
                                    <a href="#">OBRISI</a>
                                    <a href="#"><span class="fa fa-arrow-up"><!--POMERI ME GORE--></span></a>
                                    <a href="#"><span class="fa fa-arrow-down"><!--POMERI ME DOLE--></span></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table> 
            </div>

        </section>
<?php include_once __DIR__ . '/../../partial/paginationView.php'; ?>
    </div>

</main><!--main end-->
