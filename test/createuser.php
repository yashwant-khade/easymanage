<?php

if (isset($_POST['createuser'])) {

    $firstname  = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $email  = $_POST['email'];
    $homeaddress  = $_POST['homeaddress'];
    $homephone  = $_POST['homephone'];
    $cellphone  = $_POST['cellphone'];

    include ("connection.php");

    $sql = "INSERT INTO user (first_name,last_name,email,home_address,home_phone,cell_phone) VALUES ('$firstname','$lastname','$email','$homeaddress','$homephone','$cellphone')";

    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700|Nova+Round"
          rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/main.css">
    <title>Beyond</title>
    <style>
        .jumbotron {
            height: auto;
            padding-top: 100px;
        }

        .jumbotron .inner-content h1 span {
            display: inline-block;
            padding: 0 10px;
        }

        .jumbotron .inner-content h1 {
            font-size: 34px;
            letter-spacing: -2px;
        }
    </style>
</head>
<body>

<nav id="global-nav" class="navbar navbar-custom navbar-dark fixed-top navbar-expand-md" role="navigation">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" class="d-inline-block align-top" alt="">
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-md-auto">
                <li class="nav-item"><a class="page-scroll nav-link" href="index.php">home</a></li>
                <li class="hidden">|</li>
                <li class="nav-item"><a class="page-scroll nav-link " href="about.php">about</a></li>
                <li class="hidden">|</li>
                <li class="nav-item"><a class="page-scroll nav-link" href="services.php">services </a></li>
                <li class="hidden">|</li>
                <li class="nav-item"><a class="page-scroll nav-link" target="" href="portfolio.php">portfolio</a></li>
                <li class="hidden">|</li>
                <li class="nav-item"><a class="page-scroll nav-link" href="news.php">news</a></li>
                <li class="hidden">|</li>
                <li class="nav-item"><a class="page-scroll nav-link" href="contact.php">contact</a></li>
                <li class="hidden">|</li>
                <li class="nav-item"><a class="page-scroll nav-link" href="securesection.php">secure section</a></li>
                <li class="hidden">|</li>
                <li class="nav-item"><a class="page-scroll nav-link active" href="usersection.php">user<span
                                class="sr-only">(current)</span></a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron bg-image">
    <div class="gradient"></div>
    <div class="container">
        <div class="inner-content col1">
            <h1>
            </h1>
        </div>
    </div>
</div>

<div id="about-us" style="<?php echo($loginShow) ?>">
    <div class="container">
        <h3>User section</h3>
        <div class="row " id="login_div" style="margin-right: 0; margin-left: 0;">
            <div data-aos="fade-up" data-aos-duration="800" style="">
                <form class="form-group" role="form"
                      action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                      ?>" method="post">

                    <input type="text" class="form-control" style="width: 200px"
                           name="firstname" placeholder="First Name"
                           required autofocus></br>
                    <input type="text" class="form-control" style="width: 200px"
                           name="lastname" placeholder="Last Name" required></br>
                    <input type="text" class="form-control" style="width: 200px"
                           name="email" placeholder="Email"
                           required autofocus></br>
                    <input type="text" class="form-control" style="width: 200px"
                           name="homeaddress" placeholder="Home Address" required></br>
                    <input type="text" class="form-control" style="width: 200px"
                           name="homephone" placeholder="Home Phone"
                           required autofocus></br>
                    <input type="text" class="form-control" style="width: 200px"
                           name="cellphone" placeholder="Cell Phone" required></br>

                    <button class="btn btn-default" type="submit" style="margin-top: 30px;"
                            name="createuser">Create User
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>


<footer class="page-footer font-small indigo">
    <div class="gradient"></div>
    <div class="container">

        <div class="row text-center d-flex justify-content-center pt-5">
            <div class="col-md-12">
                <ul>
                    <li class="nav-item"><a class="page-scroll nav-link" href="index.php">Home</a></li>
                    <li class="hidden">|</li>
                    <li class="nav-item"><a class="page-scroll nav-link" href="about.php">About-us </a></li>
                    <li class="hidden">|</li>
                    <li class="nav-item"><a class="page-scroll nav-link" href="services.php">our services </a></li>
                    <li class="hidden">|</li>
                    <li class="nav-item"><a class="page-scroll nav-link" href="portfolio.php">portfolio </a></li>
                    <li class="hidden">|</li>
                    <li class="nav-item"><a class="page-scroll nav-link" href="news.php">news</a></li>
                    <li class="hidden">|</li>
                    <li class="nav-item"><a class="page-scroll nav-link" href="contact.php">contact</a></li>
                    <li class="hidden">|</li>
                    <li class="nav-item"><a class="page-scroll nav-link active" href="securesection.php">secure
                            section</a></li>
                    <li class="hidden">|</li>
                    <li class="nav-item"><a class="page-scroll nav-link active" href="usersection.php">user</a></li>
                </ul>
            </div>
        </div>


        <div class="footer-copyright text-center">
            <p>&copy; 2019. All rights <a href="https://www.yashwantkhade.com">Yashwant Khade</a></p>
        </div>

        <div class="row text-center d-flex justify-content-center">

            <div class="col-md-12">

                <div class="mb-5 flex-center">

                    <!-- Facebook -->
                    <a class="fb-ic" href="https://www.facebook.com/khadeyashwant" target="_blank">
                        <i class="fa fa-facebook-official fa-lg white-text mr-3" aria-hidden="true"></i>
                    </a>
                    <!--Linkedin -->
                    <a class="li-ic" href="https://www.linkedin.com/in/yashwantkhade/" target="_blank">
                        <i class="fa fa-linkedin fa-lg white-text mr-3"> </i>
                    </a>
                    <!--Instagram -->
                    <a class="li-ic" href="https://www.instagram.com/yashwant_khade/" target="_blank">
                        <i class="fa fa-instagram fa-lg white-text mr-3"> </i>
                    </a>
                </div>

            </div>

        </div>

    </div>

</footer>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>

<script src="js/animate.js"></script>
<script src="js/custom.js"></script>
<script>
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
</body>
</html>
