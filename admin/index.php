<?php include_once "../inc/DB.php" ?>
<?php include_once("include/top.php");
//$_SESSION["username"] comes from logging page
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
?>
</head>

<body>
<div id="wrapper">
    <!-- NavBar Start-->
    <?php include_once("include/header.php"); ?>
    <!-- NavBar End-->

    <div class="container-fluid body-section mt-3">
        <div class="row">
            <div class="col-md-3">
                <?php include_once("include/sidebar.php"); ?>
            </div>
            <div class="col-md-9">
                <h1>
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                    <small class="text-black-50">Statistics
                        Overview
                    </small>
                </h1>
                <hr/>
                <ol class="breadcrumb">
                    <li class="active"><i class="fas fa-tachometer-alt"></i> Dashboard </a></li>
                </ol>
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="card text-center mb-3">
                            <div class="card-body badge-primary">
                                <h1 class="lead text-white">New Comments</h1>
                                <h1 class="display-5 text-white">
                                    <i class="fas fa-comments"></i> 23
                                </h1>
                            </div>
                            <div class="card-footer bg-white row align-self-center p-1">
                                <a href="comments.php" class="lead">View All Comments <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card text-center mb-3">
                            <div class="card-body badge-danger">
                                <h1 class="lead text-white">All Posts</h1>
                                <h1 class="display-5 text-white">
                                    <i class="fas fa-file-alt"></i> 12
                                </h1>
                            </div>
                            <div class="card-footer bg-white row align-self-center p-1">
                                <a href="post.php" class="lead text-danger">View All Posts <i
                                            class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card text-center mb-3">
                            <div class="card-body badge-success">
                                <h1 class="lead text-white">All Users</h1>
                                <h1 class="display-5 text-white">
                                    <i class="fas fa-users"></i> 8
                                </h1>
                            </div>
                            <div class="card-footer bg-white row align-self-center p-1">
                                <a href="users.php" class="lead text-success">View All Users <i
                                            class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card text-center mb-3">
                            <div class="card-body badge-warning">
                                <h1 class="lead text-white">All Categories</h1>
                                <h1 class="display-5 text-white">
                                    <i class="fas fa-folder-open"></i> 10
                                </h1>
                            </div>
                            <div class="card-footer bg-white row align-self-center p-1">
                                <a href="categories.php" class="lead text-warning">View All Categories <i
                                            class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h3>All User</h3>
                <div class="table-responsive pl-0 pr-0">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th>Sr #</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>User Name</th>
                            <th>Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>2 January 2020</td>
                            <td>Md. Ruhul Amin</td>
                            <td>ruhulmath08</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>20 February 2020</td>
                            <td>Md. Zakria Islam</td>
                            <td>zakriaidb</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>23 March 2020</td>
                            <td>Md. Iraful Islam</td>
                            <td>arifdhaka09</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>22 May 2020</td>
                            <td>Md. Rezaul Karim</td>
                            <td>rezacha0</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>2 March 2020</td>
                            <td>Md. Mezbaul Amin</td>
                            <td>ruhulmath08</td>
                            <td>Admin</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <a href="#" class="btn btn-primary">View All Users</a>

                <hr/>

                <h3>New Posts</h3>
                <div class="table-responsive pl-0 pr-0">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th>Sr #</th>
                            <th>Date</th>
                            <th>Post Title</th>
                            <th>Category</th>
                            <th>Views</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>2 January 2020</td>
                            <td>Learn Java from A-Z</td>
                            <td>Java</td>
                            <td><i class="fa fa-eye"></i> 34</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>20 February 2020</td>
                            <td>Learn Android Development</td>
                            <td>Android</td>
                            <td><i class="fa fa-eye"></i> 56</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>23 March 2020</td>
                            <td>Spring Boot For large project</td>
                            <td>Spring</td>
                            <td><i class="fa fa-eye"></i> 89</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>22 May 2020</td>
                            <td>jQuery for responsive UI design</td>
                            <td>JavaScript</td>
                            <td><i class="fa fa-eye"></i> 90</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>2 March 2020</td>
                            <td>Bootstrap For responsive Web_Design</td>
                            <td>FrontEnd Development</td>
                            <td><i class="fa fa-eye"></i> 567</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <a href="#" class="btn btn-primary">View All Posts</a>
            </div>
        </div>
    </div>

    <!--Footer Section Start-->
    <?php include_once("include/footer.php"); ?>
    <!--Footer Section Ens-->
</div>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

</html>