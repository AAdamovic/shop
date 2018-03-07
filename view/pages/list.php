
<main>
    <div class="container">
        <section class="include-table">

            <h1>List of Pages</h1>
            <a href="/pages/create.php">Create new page</a><br><br>
            <?php
            if (!empty($systemMessage)) {
                ?>
                <div class="alert alert-danger" role="alert"><?php echo $systemMessage; ?></div>
                <?php
            }
            ?>

            <?php
            if (count($allPages) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table  table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Text</th>
                                <th>Images</th>
                                <th class="text-center" style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($allPages as $value) {
                                ?>
                                <tr>
                                    <td><img style="width: 50px; height: auto;" src="<?php echo (isset($value['image'])) ? $value['image'] : "/img/no-image.png"; ?>"></td>
                                    <td><?php echo $value['title']; ?></td>
                                    <td><?php echo $value['text']; ?></td>
                                   
                                    <td class="text-center">
                                        <a href="/pages/detail.php?id=<?php echo $value['id']; ?>">View</a>
                                        <a href="/pages/update.php?id=<?php echo $value['id']; ?>">Update</a>
                                        <a href="/pages/delete.php?id=<?php echo $value['id']; ?>">Delete</a>
                                        <a href="/pages/deletePhoto.php?id=<?php echo $value['id']; ?>">Delete photo</a>
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
                echo "There aren't Pages";
            }
            ?>
        </section>                
    </div>
</main>

