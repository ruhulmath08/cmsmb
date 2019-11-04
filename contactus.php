<?php include_once("inc/top.php"); ?>
</head>

<body>
<!-- NavBar Start -->
<?php include_once("inc/header.php"); ?>
<!-- NavBar End -->

<!-- Jumbotron Start -->
<div class="jumbotron">
    <div class="container">
        <div id="details" class="d-flex justify-content-center flex-column animated fadeInLeft">
            <h1>Contact <span>Us</span></h1>
            <p>We are available 24x7. So Feel to Contact us.</p>
        </div>
    </div>
    <img src="images/top-image.jpg" alt="Top Image">
</div>
<!-- Jumbotron End -->

<!-- Main Section Start-->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8 mt-3">
                <div class="col-md-12">
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe width="100%" height="500" id="gmap_canvas"
                                    src="https://maps.google.com/maps?q=idb%20vabon%20dhaka&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                            </iframe>
                            <a href="https://www.utilitysavingexpert.com">Utility Saving Expert</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3 contact-form">
                    <h2>Contact Form</h2>
                    <hr>
                    <form action="">
                        <div class="form-group">
                            <label for="full-name">Full Name*:</label>
                            <input type="text" id="full-name" class="form-control" placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <label for="email">email*:</label>
                            <input type="email" id="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="website">Website:</label>
                            <input type="text" id="website" class="form-control" placeholder="Website">
                        </div>
                        <div class="form-group">
                            <label for="message">Full Name:</label>
                            <textarea class="form-control" id="message" cols="30" rows="10"
                                      placeholder="Write your message here..."></textarea>
                        </div>
                        <input class="btn btn-primary" type="submit" name="submit" value="Submin">
                    </form>
                </div>
            </div>

            <!--Sidebar start -->
            <div class="col-md-4 mt-3">
                <?php include_once("inc/sidebar.php"); ?>
            </div>
            <!-- Sidebar End-->
        </div>
    </div><!-- Row end -->
    </div><!-- container End-->
</section>
<!-- Main Section End-->

<!-- Footer Start-->
<?php include_once("inc/footer.php"); ?>
<!-- Footer End-->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

</html>