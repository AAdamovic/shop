<?php ?>
<main>
    <div class="container">
        <section class="include-table">

            <h1>Analiza Proizvoda</h1>
            <div class=" form-group">
                <form action="" method="get">
                <label>Filter by product</label><br>
                <input type="text" name="search" value="<?php echo isset($formData["search"]) ? htmlspecialchars($formData["search"]) : ""; ?>"> <br> 
                <?php
                if (isset($formErrors["search"])) {
                    foreach ($formErrors["search"] as $errorMessage) {
                        ?>
                        <span class="error"><?php echo $errorMessage; ?></span>
                        <?php
                    }
                }
                ?>
            <br>  <input type="submit" name="click" value="Search">
                </form>
            </div>
            <div class="table-responsive">
                <table class="table  table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>Proizvod</th>
                            <th>Kolicina</th>
                            <th>Ukupno popusta</th>
                            <th>Ukupna dobit</th>
                            <th>Akcija</th>

                        </tr>
                    </thead>
<?php
foreach ($analyzedProducts as $value) {
    ?>
                        <tbody>
                            <tr>
                                <td><?php echo $value['title']; ?></td>
                                <td><?php echo $value['kolicina']; ?></td>
                                <td><?php echo (is_null($value['popust']) ? 'Nema popusta' : $value['popust'] . ' din') ?></td>
                                <td><?php echo $value['zarada'] . ' din'; ?></td>
                                <td>
                                    <a href="#">DETALJNIJE</a>
                                    <a href="#">IZMENI</a>
                                    <a href="#">OBRISI</a>
                                    <a href="#"><span class="fa fa-arrow-up"><!--POMERI ME GORE--></span></a>
                                    <a href="#"><span class="fa fa-arrow-down"><!--POMERI ME DOLE--></span></a>
                                </td>
                            </tr>

                        </tbody>
    <?php
}
?>
                </table> 
            </div>
            
        </section>
        <?php include_once __DIR__ . '/../../partial/paginationView.php'; ?>
    </div>
   
</main>