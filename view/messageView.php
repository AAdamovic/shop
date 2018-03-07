<main>
    <div class="container">
        <section class="include-table">

            <h1>Message</h1>

            <?php
            if (!empty($systemMessage)) {
                ?>
                <div class="alert alert-danger" role="alert"><?php echo $systemMessage; ?></div>
                <?php
            }
            ?>
        </section>
    </div>
</main>