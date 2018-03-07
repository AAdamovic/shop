
<main>
    <div class="container">
        <section class="include-table">

            <h1>Successful order</h1>

            <?php
            if (!empty($_SESSION['systemMessage'])) {
                $systemMessage = $_SESSION['systemMessage'];
                ?>
                <div class="alert alert-danger" role="alert"><?php echo $systemMessage; ?></div>
                <?php
            }
            ?>
        </section>
    </div>
</main>