<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo $pageTitle; ?> - CUBES SCHOOL PHP COURSE</title>

        <!-- Bootstrap -->
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Leckerli+One|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="/css/responsive.css" rel="stylesheet" type="text/css"/>
        <link href="/css/common.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body id="top">

        <header>
            <div class="header-top text-center">
                <div class="container">
                    <ul class="sign-in list-inline">
                        <?php
                            // ako nije startovana sesija ti je startuj
                            if(!isset($_SESSION)){
                                session_start();
                            }

                            
                            // da li sam ulogovan
                            if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){
                                // ispisi link za logout
                                ?>
                                    <li><a href="/pages/list.php">Pages</a></li>
                                    <li><a href="/categories/list.php">Categories</a></li>
                                    <li><a href="/products/list.php">Products</a></li>
                                    <li><a href="/shopping-cart/analyze/order.php">Orders </a></li>
                                    <li><a href="/shopping-cart/analyze/products.php">Analyze</a></li>
                                    <li><a href="/users/list.php">Users list</a></li>
                                    <li><?php echo $_SESSION['userName'] ?></li>,
                                    <li><a href="/logout.php">Logout</a></li>
                                <?php
                            }else{
                                // ispisi link za login stranicu
                                ?>
                                    <li><a href="/login.php">Login</a></li>
                                <?php
                            }
                        ?>
                    </ul>
                    <div class="social">
                        <a href="#"><span class="fa fa-facebook"></span></a>
                        <a href="#"><span class="fa fa-twitter"></span></a>
                        <a href="#"><span class="fa fa-linkedin"></span></a>
                    </div>
                </div>
            </div>
        </header>