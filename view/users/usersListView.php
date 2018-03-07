<main>
    <div class="container">
        <section class="include-table">

            <h1>List of users</h1>
             <a href="/users/create.php">Create New user</a><br><br>
            <?php
            if (!empty($systemMessage)) {
                ?>
                <div class="alert alert-danger" role="alert"><?php echo $systemMessage; ?></div>
                <?php
            }
            ?>

            <?php
            if (count($users) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table  table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Surname</th>
                                <th>Email</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($users as $value) {
                                ?>
                                <tr>
                                    <td><?php echo $value['name']; ?></td>
                                    <td><?php echo $value['surname']; ?></td>
                                    <td><?php echo $value['email']; ?></td>
                                    <td>
                                        <?php
                                        if ($value['ban'] == 1) {
                                            echo "Not active";
                                        }
                                        if ($value['ban'] == 0) {
                                            echo "Active";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="/users/update.php?id=<?php echo $value['id']; ?>">Update</a>
                                        <a href="/users/delete.php?id=<?php echo $value['id']; ?>">Delete</a>
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
                echo "Nema unsesenih proizvoda";
            }
            ?>
        </section>

    </div>
</main><!--main end-->