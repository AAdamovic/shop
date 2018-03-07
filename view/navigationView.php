<nav class="navbar navbar-default text-uppercase" style="background-color: #e1e1e1;">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="/img/logo.png" alt="WEB SCHOOL" class="img-responsive">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="main-menu">
            <ul class="nav navbar-nav navbar-right text-center">
                <li><a href="/">home</a></li>
                <li><span class="fa fa-newspaper-o" aria-hidden="true"> Pages:</span></li>
                <?php
                if (count($pagesNavigation) > 0) {
                    foreach ($pagesNavigation as $key => $value) {
                        ?>
                        <li><a style="padding: 15px 5px;" href="/pages/detail.php?id=<?php echo $value['id'] ?>"><?php echo $value['title']; ?></a></li>
                        <?php
                    }
                }
                ?>
                        <li><span class="fa fa-shopping-basket" aria-hidden="true"> Categories:</span></li>       
                <?php
                if (count($categories) > 0) {
                    foreach ($categories as $key => $value) {
                        ?>
                        <li><a style="padding: 15px 5px;" href="/products/category.php?id=<?php echo $value['id'] ?>"><?php echo $value['name'] . '(' . $value['total'] . ')'; ?></a></li>
                        <?php
                    }
                }
                ?>
                <?php
                if (isset($_SESSION['cart'])) {
                    $cart = $_SESSION['cart'];
                } else {
                    $cart = array();
                }
                ?>
                <li class="cart"><a href="/shopping-cart/change-product.php"><span class="fa fa-shopping-cart"></span><span class="number-products"><?php echo count($cart); ?></span></a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>