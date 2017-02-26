<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Agency - Start Bootstrap Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Theme CSS -->
    <link href="css/agency.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">Alan Philpott</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a href="index.php">Products</a>
                    </li>
                    <li>
                        <a href="customer.php">Customers</a>
                    </li>
                    <li>
                        <a href="sales.php">Sales</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header Edited -->
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-heading">MindFactory</div>
                <div class="intro-lead-in">Graphics Card's On A Budget</div>
            </div>
        </div>
    </header>

    <!-- Services Section Edited -->
    <section id="services">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Products</h2>

                    <form method = "post" action = "index.php">
                        <input type = "text" name = "nameSearch" placeholder = "Search For A Product" />
                        <input type = "submit" name = "searchButton" value = "Search" />
                        <input type = "submit" name = "orderByPrice" value = "Order By Price" />
                    </form>

                </div>
            </div>

            <div class="row text-center">

            <!-- PHP Start -->

            <?php

            // -- Default viewing with all available products listed --
            if(!isset($_POST['searchButton']) AND !isset($_POST['orderByPrice'])) {

                include 'connection.php';

                $statement = "SELECT * FROM stock WHERE stockCount > 0";

                $result = mysqli_query($connection, $statement);

                if(!$result)
                {
                    echo "Query Failed";
                    exit();
                }

                else
                {
                    if(mysqli_num_rows($result) < 1)
                    {
                        echo "No Products Exist";
                    }

                    else
                    {
                        while($row = mysqli_fetch_array($result))
                        {
                            echo ("
                                <div class=\"col-md-4\">
                                    <span class=\"fa-stack fa-4x\">
                                        <i class=\"fa fa-circle fa-stack-2x text-primary\"></i>
                                        <i class=\"fa fa-shopping-cart fa-stack-1x fa-inverse\"></i>
                                    </span>
                                    <h4 class=\"service-heading\">" . $row['name'] . "</h4>
                                    <p class=\"text-muted\">Manufacturer: " . $row['manufacturer'] . "<br>Specification: " . $row['specification'] . "<br>Price: &euro;" . $row['salePrice'] .  " - (" . $row['stockCount'] . ") Left In Stock</p>
                                    
                                    <form method = 'post' action = 'checkout.php'>
                                        <input type = 'text' name = 'saleQuantity' placeholder = 'Quantity To Buy' />
                                        <input type = 'submit' name = 'buyButton' value = 'Buy' />
                                        <input type = 'hidden' name = 'stockID' value = $row[stockID] />
                                        <input type = 'hidden' name = 'salePrice' value = $row[salePrice] />
                                    </form>
                                </div>");
                        }
                    }
                }
                mysqli_free_result($result);
                mysqli_close($connection);
            }

            // -- When a product is searched for, this will be done --
            if(isset($_POST['searchButton'])) {

                $productSearch = $_POST['nameSearch'];

                if($productSearch == "")
                {
                    echo ("You Cannot Search for Nothing. Please Go Back or Search Again.");
                    exit();
                }

                include 'connection.php';

                $productSearch = mysqli_real_escape_string($connection,$productSearch);
                $statement = "SELECT * FROM stock WHERE name LIKE '%$productSearch%' OR specification LIKE '%$productSearch%' OR manufacturer LIKE '%$productSearch%'";

                $result = mysqli_query($connection, $statement);

                if(!$result)
                {
                    echo "Query Failed";
                    exit();
                }

                else
                {
                    if(mysqli_num_rows($result) < 1)
                    {
                        echo "No products contain this information. Please return to Home or search again.";
                    }
                    else
                    {
                        echo ("<h5 style='margin-bottom:2em;'>All Products Matching Your Search Reference: '" . $productSearch . "'</h5>");

                        while($row = mysqli_fetch_array($result))
                        {
                            echo ("
                                <div class=\"col-md-4\">
                                    <span class=\"fa-stack fa-4x\">
                                        <i class=\"fa fa-circle fa-stack-2x text-primary\"></i>
                                        <i class=\"fa fa-shopping-cart fa-stack-1x fa-inverse\"></i>
                                    </span>
                                    <h4 class=\"service-heading\">Name: " . $row['name'] . "</h4>
                                    <p class=\"text-muted\">Manufacturer: " . $row['manufacturer'] . "<br>Specification: " . $row['specification'] . "<br>Price: &euro;" . $row['salePrice'] .  " - (" . $row['stockCount'] . ") Left In Stock</p>
                                    
                                    <form method = 'post' action = 'checkout.php'>
                                        <input type = 'text' name = 'saleQuantity' placeholder = 'Quantity To Buy' />
                                        <input type = 'submit' name = 'buyButton' value = 'Buy' />
                                        <input type = 'hidden' name = 'stockID' value = $row[stockID] />
                                        <input type = 'hidden' name = 'salePrice' value = $row[salePrice] />
                                    </form>
                                </div>");
                        }
                    }
                }
                mysqli_free_result($result);
                mysqli_close($connection);
            }

            // -- This orders all products by price when requested --
            if(isset($_POST['orderByPrice'])) {

                include 'connection.php';

                $statement = "SELECT * FROM stock ORDER BY salePrice ASC";

                $result = mysqli_query($connection, $statement);

                if(!$result)
                {
                    echo "Query Failed";
                    exit();
                }

                else
                {
                    if(mysqli_num_rows($result) < 1)
                    {
                        echo "No Products Exist";
                    }

                    else
                    {
                        while($row = mysqli_fetch_array($result))
                        {
                            echo ("
                                <div class=\"col-md-4\">
                                    <span class=\"fa-stack fa-4x\">
                                        <i class=\"fa fa-circle fa-stack-2x text-primary\"></i>
                                        <i class=\"fa fa-shopping-cart fa-stack-1x fa-inverse\"></i>
                                    </span>
                                    <h4 class=\"service-heading\">Name: " . $row['name'] . "</h4>
                                    <p class=\"text-muted\">Manufacturer: " . $row['manufacturer'] . "<br>Specification: " . $row['specification'] . "<br>Price: &euro;" . $row['salePrice'] .  " - (" . $row['stockCount'] . ") Left In Stock</p>
                                    
                                    <form method = 'post' action = 'checkout.php'>
                                        <input type = 'text' name = 'saleQuantity' placeholder = 'Quantity To Buy' />
                                        <input type = 'submit' name = 'buyButton' value = 'Buy' />
                                        <input type = 'hidden' name = 'stockID' value = $row[stockID] />
                                        <input type = 'hidden' name = 'salePrice' value = $row[salePrice] />
                                    </form>
                                </div>");
                        }
                    }
                }
                mysqli_free_result($result);
                mysqli_close($connection);
            }

            ?>
            </div>

            <!-- PHP End -->

        </div>
    </section>

    <!-- Footer Edited -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; MindFactory 2016</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li><a href="#">Privacy Policy</a>
                        </li>
                        <li><a href="#">Terms of Use</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/agency.min.js"></script>

</body>

</html>
