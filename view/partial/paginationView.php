<!-- PAGINATION START -->
<?php
    if(!($numberOfRowsPerPage > $totalNumberOfRows)){
        ?>
            <section class="paginacija text-center">
                <ul class="pagination">
                    <?php
                        for ($i = 1; $i <= $totalNumberOfPages; $i++) {
                            if($i == $page){
                                $classActive = "active";
                            }else{
                                $classActive = "";
                            }
                            ?>
                    <li class="<?php echo $classActive; ?>"><a href="<?php if(!isset($search)){echo $basePath;}else{    echo $basePath . 'search=' . $search;} ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php
                        }
                    ?>
                </ul>
            </section>
        <?php
    }
?>
<!-- PAGINATION END -->
