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
                <h2 class="section-heading">Register A Customer</h2>

                <form method="post" action="customer.php">
                    <label>Enter Email</label><br>
                    <input type="text" name="email" placeholder="Enter Email" /><br><br>
                    <label>Enter First Name</label><br>
                    <input type="text" name="forename" placeholder="Enter First Name" /><br><br>
                    <label>Enter Last Name</label><br>
                    <input type="text" name="surname" placeholder="Enter Last Name" /><br><br>
                    <label>Enter Address</label><br>
                    <input type="text" name="address" placeholder="Enter Address" /><br><br>
                    <input type="submit" name="register" value="Register Customer" />
                </form>

            </div>
        </div>

        <div class="row text-center">

            <!-- PHP Start -->

            <?php

            // -- When registering a new customer, do this --
            if(isset($_POST['register'])){
                $forename = $_POST['forename'];
                $surname = $_POST['surname'];
                $address = $_POST['address'];
                $email = $_POST['email'];

                if($forename == "" OR $surname == "" OR $address == "" OR $email == "") {
                    echo("You Did Not Enter All Details<br><br>");
                }
                else {
                    include 'connection.php';

                    $forenameEsc = mysqli_real_escape_string($connection,$forename);
                    $surnameEsc = mysqli_real_escape_string($connection,$surname);
                    $addressEsc = mysqli_real_escape_string($connection,$address);
                    $emailEsc = mysqli_real_escape_string($connection,$email);

                    $sql = "INSERT INTO customer(email,forename,surname,address) VALUES('$emailEsc','$forenameEsc','$surnameEsc','$addressEsc')";

                    $result = mysqli_query($connection,$sql);

                    if($result == 0) {
                        echo("<p>Error Registering: ". mysqli_error($connection) . "</p>");
                    }
                    else {
                        echo("<br><strong>Success</strong>. User: " . $forename . " " . $surname . " Has Been Registered");
                    }
                }
            }
            ?>

            <hr>
            <h2 class='section-heading'>Update or Delete a Customer</h2>

            <?php

            // -- Displaying a list of all customers

            if(!isset($_POST['update']) AND !isset($_POST['delete'])) {

                include 'connection.php';

                $statement = "SELECT * FROM customer";

                $result = mysqli_query($connection, $statement);

                if(!$result) {
                    echo "Query One Failed";
                    exit();
                }
                else {
                    if(mysqli_num_rows($result) < 1) {
                        echo "No Users Created";
                    }
                    else {
                        echo "<div style='overflow-x:auto;'><table border=1>";
                        echo "<tr><th>Customer ID</th><th>Email</th><th>First Name</th><th>Second Name</th><th>Address</th><th>Update</th><th>Delete</th></tr>";
                        while ($row = mysqli_fetch_array($result)) {
                            $custID = $row['custID'];
                            echo ("<tr><td>");
                            echo $custID;
                            echo("</td><td>");
                            echo $row['email'];
                            echo("</td><td>");
                            echo $row['forename'];
                            echo("</td><td>");
                            echo $row['surname'];
                            echo("</td><td>");
                            echo $row['address'];
                            echo("</td><td>");
                            echo("<form method='post' action='customer.php'><input type='hidden' name='custID' value='$custID'/><input type='submit' name='update' value='Update This User' /></form>");
                            echo("</td><td>");
                            echo("<form method='post' action='customer.php'><input type='hidden' name='custID' value='$custID'/><input type='submit' name='delete' value='Delete This User' /></form>");
                            echo("</td></tr>");
                        }
                        echo "</table></div>";
                    }
                }
                mysqli_free_result($result);
                mysqli_close($connection);

            }

            // -- When a user is chosen to update, do this --

            if(isset($_POST['update'])) {
                $custID = (int) $_POST['custID'];

                include 'connection.php';

                $statement = "SELECT * FROM customer WHERE custID = $custID";

                $result = mysqli_query($connection,$statement);

                if(!$result) {
                    echo "Query Failed";
                    exit();
                }

                else {
                    $row = mysqli_fetch_array($result);
                    $firstName = $row['forename'];
                    $lastName = $row['surname'];
                    $address = $row['address'];

                    $sFirstName = stripslashes($firstName);
                    $sLastName = stripslashes($lastName);
                    $sAddress = stripslashes($address);

                    echo ("
                            <form method='post' action = 'customer.php'>
                                <label>New Forename: <br>
                                    <input type='text' name='ud_forename' value=\"$sFirstName\" />
                                </label><br>
                            
                                <label>New Surname: <br>
                                    <input type='text' name='ud_surname' value=\"$sLastName\" />
                                </label><br>
                                
                                <label>New Address: <br>
                                    <input type='text' name='ud_address' value=\"$sAddress\" />
                                </label><br><br>
                            
                                <input type='hidden' name='userToUpdate' value='$custID' />
                            
                                <input type='submit' name='user_update' value='Confirm Changes' />
                            </form>");

                }
                mysqli_free_result($result);
                mysqli_close($connection);
            }

            // -- When new customer values have been entered, do this --

            if(isset($_POST['user_update'])) {
                include 'connection.php';

                $updatedForename = $_POST['ud_forename'];
                $updatedSurname = $_POST['ud_surname'];
                $updatedAddress = $_POST['ud_address'];
                $userToUpdate = (int) $_POST['userToUpdate'];

                if($updatedForename == '' OR $updatedSurname == '' OR $updatedAddress == '') {
                    echo "<br>Missing Information. Please Try Again";
                    exit();
                }

                $updatedForenameEsc = mysqli_real_escape_string($connection,$updatedForename);
                $updatedSurnameEsc = mysqli_real_escape_string($connection,$updatedSurname);
                $updatedAddressEsc = mysqli_real_escape_string($connection,$updatedAddress);

                $statement = "UPDATE customer SET forename = '$updatedForenameEsc', surname = '$updatedSurnameEsc', address = '$updatedAddressEsc' WHERE custID = $userToUpdate";

                $result = mysqli_query($connection,$statement);

                if(!$result) {
                    echo "Query Failed";
                    exit();
                }

                else {
                    if(mysqli_affected_rows($connection) < 1) {
                        echo "No Updates Made";
                    }
                    else {
                        echo ("<br>Customer ID Number: " . $userToUpdate . " Updated");
                        mysqli_close($connection);
                    }
                }
            }

            // -- When a user is chosen to delete, do this --

            if(isset($_POST['delete'])) {
                include 'connection.php';

                $userToDelete = (int) $_POST['custID'];

                $statement = "DELETE FROM customer WHERE custID = $userToDelete";

                $result = mysqli_query($connection,$statement);

                if(!$result) {
                    echo "Query Failed - " . mysqli_error($connection);
                    echo "<br><br><strong>Error: </strong>Customer Exists In A Sale";
                    exit();
                }

                else {
                    if(mysqli_affected_rows($connection) < 1) {
                        echo "No Deletion Made";
                    }
                    else {
                        echo ("<br>Customer ID Number: " . $userToDelete . " Deleted");
                        mysqli_close($connection);
                    }
                }
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
