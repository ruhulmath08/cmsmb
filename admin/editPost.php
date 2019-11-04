<?php header('Access-Control-Allow-Origin: *'); ?>
<?php include_once "../inc/DB.php" ?>
<?php include_once("include/top.php");
//$_SESSION["username"] comes from logging page
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

//get value from logging page
$session_username = $_SESSION["username"];
$session_role = $_SESSION["role"];
$session_user_image = $_SESSION["author_image"];
//var_dump($session_user_image . "---" . $session_username . "---" . $session_role);

if (isset($_GET["edit"])) {
    $edit_id = $_GET["edit"];
    if ($session_role == "admin") {
        $get_query = "SELECT * FROM posts WHERE id = '$edit_id'";
        $get_run = mysqli_query($connectionDB, $get_query);
    } elseif ($session_role == "author") {
        $get_query = "SELECT * FROM posts WHERE id = '$edit_id' && author = '$session_username'";
        $get_run = mysqli_query($connectionDB, $get_query);
    }
    if (mysqli_num_rows($get_run) > 0) {
        $get_row = mysqli_fetch_array($get_run);
        $post_title = $get_row["title"];
        $post_data = htmlentities($get_row["post_data"]);
        $post_image = $get_row["image"];
        $post_category = $get_row["categories"];
        $post_tags = $get_row["tags"];
        $post_status = $get_row["status"];

    } else {
        header("Location: post.php");
    }
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
                    <i class="fas fa-pencil-alt"></i> Edit Post
                    <small class="text-black-50">Edit Post Details</small>
                </h1>
                <hr/>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-tachometer-alt"></i> Dashboard /</a></li>
                    <li class="active pl-2"><i class="fas fa-pencil-alt"></i> Edit Post</li>
                </ol>

                <!-- insert post data in database -->
                <?php
                if (isset($_POST["update"])) {
                    $update_date = time();
                    $update_title = mysqli_real_escape_string($connectionDB, $_POST["title"]);
                    $update_data = mysqli_real_escape_string($connectionDB, $_POST["post-data"]);
                    $update_category = $_POST["categories"];
                    $update_tags = $_POST["tags"];
                    $update_status = $_POST["status"];
                    $update_image = $_FILES["image"]["name"];

                    if (empty($update_image)) {
                        $update_image = $post_image;
                    } else {
                        //if image field is selected do work for upload image
                        $imageArr = explode('.', $update_image);
                        $rand = rand(10000, 99999);
                        $newPostImageName = $imageArr[0] . '_' . $rand . '_' . $update_date . '.' . $imageArr[1];
                        $uploadPostImagePath = "uploads/blog/" . $newPostImageName;
                        $tmp_name = $_FILES["image"]["tmp_name"];
                    }

                    if (empty($update_title) || empty($update_data) || empty($update_category) || empty($update_tags) || empty($update_status)) {
                        $error_message = "All (*) fields are required!!!";
                    } else {
                        $update_query = "UPDATE posts SET date = '$update_date', title = '$update_title', post_data = '$update_data', categories = '$update_category', tags = '$update_tags', status = '$update_status'";
                        if (!empty($newPostImageName)) {
                            $update_query .= ", image = '$newPostImageName'";
                        }
                        $update_query .= " WHERE id = '$edit_id'";
                        //var_dump($update_query);
                        if (mysqli_query($connectionDB, $update_query)) {
                            $success_message = "Post added successfully!!!";
                            if (!empty($newPostImageName)) {
                                $target_pate_to_delete_image = "uploads/blog/$post_image";
                                unlink($target_pate_to_delete_image);
                                unlink("../$target_pate_to_delete_image");
                                move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPostImagePath);
                                copy($uploadPostImagePath, "../$uploadPostImagePath");
//                                if (move_uploaded_file($tmp_name, $uploadPostImagePath)) {
//                                    copy($uploadPostImagePath, "../$uploadPostImagePath");
//                                }
                            }
                            $post_title = "";
                            $post_data = "";
                            $post_category = "";
                            $post_tags = "";
                            $post_status = "";
                        } else {
                            $error_message = "Something wrong, post has not been updated!!!";
                        }
                    }
                }
                ?>
                <!-- insert post data in database -->

                <!-- Display message -->
                <?php
                if (isset($error_message)) {
                    echo "<div class='alert alert-danger alert-dismissible'>
                            <a href='#'class='close' data-dismiss='alert' aria-label='close'>&times;</a>$error_message
                            </div>";
                } else if (isset($success_message)) {
                    echo "<div class='alert alert-success alert-dismissible'>
                            <a href='#'class='close' data-dismiss='alert' aria-label='close'>&times;</a>$success_message
                            </div>";
                }
                ?>
                <!-- Display message -->

                <hr/>

                <div class="row">
                    <div class="col-12">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="text-primary" for="title">Title:(*)</label>
                                <input type="text" name="title" placeholder="Type Post Title Here"
                                       value="<?php if (isset($post_title)) echo $post_title; ?>" class="form-control">
                            </div>

                            <div class="form-group">
                                <a href="media.php" class="btn btn-primary" target="_blank">Add Media</a>
                            </div>

                            <div class="form-group">
                                <textarea name="post-data" id="textarea" rows="10" cols="30"
                                          class="form-control"><?php if (isset($post_data)) echo $post_data; ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="text-primary for=" file">Post Image:(*)</label>
                                        <br/>
                                        <input type="file" name="image">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="text-primary for=" title">Category:(*)</label>
                                        <select name="categories" id="categories" class="form-control">
                                            <?php
                                            $cat_query = "SELECT category FROM categories ORDER BY id DESC";
                                            $cat_run = mysqli_query($connectionDB, $cat_query);
                                            if (mysqli_num_rows($cat_run) > 0) {
                                                while ($dataRow = mysqli_fetch_array($cat_run)) {
                                                    $cat_name = $dataRow["category"];
                                                    //echo "<option value='" . $cat_name . "' >" . ucwords($cat_name) . "</option>";
                                                    echo "<option value='" . $cat_name . "' " . ((isset($post_category) && $post_category == $cat_name) ? "selected" : "") . ">" . ucwords($cat_name) . "</option>";
                                                }
                                            } else {
                                                echo "<h3>No Category Available</h3>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="text-primary for=" tags">Tags:(*)</label>
                                        <br/>
                                        <input type="text" name="tags" placeholder="Your Tags Here"
                                               value="<?php if (isset($post_tags)) echo $post_tags; ?>"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="text-primary for=" status">Status:(*)</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="publish" <?php if (isset($post_status) && $post_status == "publish") {
                                                echo "selected";
                                            } ?>>Publish
                                            </option>
                                            <option value="draft" <?php if (isset($post_status) && $post_status == "draft") {
                                                echo "selected";
                                            } ?>>Draft
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary float-right" name="update" value="Update Post">
                        </form>
                    </div>
                </div>
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
<!--tinymd for textarea-->
<script src="https://cdn.tiny.cloud/1/o9aqyeel91oxlhopai2lkukq09gr0waq4kezg4oxynmxe62m/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

<script>
    var mentionsFetchFunction = function (query, success) {
        var users = [
            "Terry Green", "Edward Carroll", "Virginia Turner", "Alexander Schneider", "Gary Vasquez", "Randy Howell",
            "Katherine Moore", "Betty Washington", "Grace Chapman", "Christina Nguyen", "Danielle Rose", "Thomas Freeman",
            "Thomas Armstrong", "Vincent Lee", "Brittany Kelley", "Brenda Wheeler", "Amy Price", "Hannah Harvey",
            "Bobby Howard", "Frank Fox", "Diane Hopkins", "Johnny Hawkins", "Sean Alexander", "Emma Roberts", "Thomas Snyder",
            "Thomas Allen", "Rebecca Ross", "Amy Boyd", "Kenneth Watkins", "Sarah Tucker", "Lawrence Burke", "Emma Carr",
            "Zachary Mason", "John Scott", "Michelle Davis", "Nicholas Cole", "Gerald Nelson", "Emily Smith", "Christian Stephens",
            "Grace Carr", "Arthur Watkins", "Frances Baker", "Katherine Cook", "Roger Wallace", "Pamela Arnold", "Linda Barnes",
            "Jacob Warren", "Billy Ramirez", "Pamela Walsh", "Paul Wade", "Katherine Campbell", "Jeffrey Berry", "Patrick Bowman",
            "Dennis Alvarez", "Crystal Lucas", "Howard Mendoza", "Patricia Wallace", "Peter Stone", "Tiffany Lane", "Joe Perkins",
            "Gloria Reynolds", "Willie Fernandez", "Doris Harper", "Heather Sandoval", "Danielle Franklin", "Ann Ellis",
            "Christopher Hernandez", "Pamela Perry", "Matthew Henderson", "Jesse Mitchell", "Olivia Reed", "David Clark", "Juan Taylor",
            "Michael Garrett", "Gerald Guerrero", "Jerry Coleman", "Joyce Vasquez", "Jane Bryant", "Sean West", "Deborah Bradley",
            "Phillip Castillo", "Martha Coleman", "Ryan Santos", "Harold Hanson", "Frances Hoffman", "Heather Fisher", "Martha Martin",
            "George Gray", "Rachel Herrera", "Billy Hart", "Kelly Campbell", "Kelly Marshall", "Doris Simmons", "Julie George",
            "Raymond Burke", "Ruth Hart", "Jack Schmidt", "Billy Schmidt", "Ruth Wagner", "Zachary Estrada", "Olivia Griffin", "Ann Hayes",
            "Julia Weaver", "Anna Nelson", "Willie Anderson", "Anna Schneider", "Debra Torres", "Jordan Holmes", "Thomas Dean",
            "Maria Burton", "Terry Long", "Danielle McDonald", "Kyle Flores", "Cheryl Garcia", "Judy Delgado", "Karen Elliott",
            "Vincent Ortiz", "Ann Wright", "Ann Ramos", "Roy Jensen", "Keith Cunningham", "Mary Campbell", "Jesse Ortiz", "Joseph Mendoza",
            "Nathan Bishop", "Lori Valdez", "Tammy Jacobs", "Mary West", "Juan Mitchell", "Thomas Adams", "Christian Martinez", "James Ramos",
            "Deborah Ross", "Eric Holmes", "Thomas Diaz", "Sharon Morales", "Kathryn Hamilton", "Helen Edwards", "Betty Powell",
            "Harry Campbell", "Raymond Perkins", "Melissa Wallace", "Danielle Hicks", "Harold Brewer", "Jack Burns", "Anna Robinson",
            "Dorothy Nguyen", "Jane Dean", "Janice Hunter", "Ryan Moore", "Brian Riley", "Brittany Bradley", "Phillip Ortega", "William Fisher",
            "Jennifer Schultz", "Samantha Perez", "Linda Carr", "Ann Brown", "Shirley Kim", "Jeremy Alvarez", "Dylan Oliver", "Roy Gomez",
            "Ethan Brewer", "Ruth Lucas", "Marilyn Myers", "Danielle Wright", "Jose Meyer", "Bobby Brown", "Angela Crawford", "Brandon Willis",
            "Kyle McDonald", "Aaron Valdez", "Kevin Webb", "Ashley Gordon", "Karen Jenkins", "Johnny Santos", "Ashley Henderson", "Amy Walters",
            "Amber Rodriguez", "Thomas Ross", "Dorothy Wells", "Jennifer Murphy", "Douglas Phillips", "Helen Johnston", "Nathan Hawkins",
            "Roger Mitchell", "Michael Young", "Eugene Cruz", "Kevin Snyder", "Frank Ryan", "Tiffany Peters", "Beverly Garza", "Maria Wright",
            "Shirley Jensen", "Carolyn Munoz", "Kathleen Day", "Ethan Meyer", "Rachel Fields", "Joan Bell", "Ashley Sims", "Sara Fields",
            "Elizabeth Willis", "Ralph Torres", "Charles Lopez", "Aaron Green", "Arthur Hanson", "Betty Snyder", "Jose Romero", "Linda Martinez",
            "Zachary Tran", "Sean Matthews", "Eric Elliott", "Kimberly Welch", "Jason Bennett", "Nicole Patel", "Emily Guzman", "Lori Snyder",
            "Sandra White", "Christina Lawson", "Jacob Campbell", "Ruth Foster", "Mark McDonald", "Carol Williams", "Alice Washington",
            "Brandon Ross", "Judy Burns", "Zachary Hawkins", "Julie Chavez", "Randy Duncan", "Lisa Robinson", "Jacqueline Reynolds", "Paul Weaver",
            "Edward Gilbert", "Deborah Butler", "Frances Fox", "Joshua Schmidt", "Ashley Oliver", "Martha Chavez", "Heather Hudson",
            "Lauren Collins", "Catherine Marshall", "Katherine Wells", "Robert Munoz", "Pamela Nelson", "Dylan Bowman", "Virginia Snyder",
            "Janet Ruiz", "Ralph Burton", "Jose Bryant", "Russell Medina", "Brittany Snyder", "Richard Cruz", "Matthew Jimenez", "Danielle Graham",
            "Steven Guerrero", "Benjamin Matthews", "Janet Mendoza", "Harry Brewer", "Scott Cooper", "Alexander Keller", "Virginia Gordon",
            "Randy Scott", "Kimberly Olson", "Helen Lynch", "Ronald Garcia", "Joseph Willis", "Philip Walker", "Tiffany Harris", "Brittany Weber",
            "Gregory Harris", "Sean Owens", "Wayne Meyer", "Roy McCoy", "Keith Lucas", "Christian Watkins", "Christopher Porter", "Sandra Lopez",
            "Harry Ward", "Julie Sims", "Albert Keller", "Lori Ortiz", "Virginia Henry", "Samuel Green", "Judith Cole", "Ethan Castillo", "Angela Ellis",
            "Amy Reid", "Jason Brewer", "Aaron Clark", "Aaron Elliott", "Doris Herrera", "Howard Castro", "Kenneth Davis", "Austin Spencer",
            "Jonathan Marshall", "Phillip Nelson", "Julia Guzman", "Robert Hansen", "Kevin Anderson", "Gerald Arnold", "Austin Castro", "Zachary Moore",
            "Joseph Cooper", "Barbara Black", "Albert Mendez", "Marie Lane", "Jacob Nichols", "Virginia Marshall", "Aaron Miller", "Linda Harvey",
            "Christopher Morris", "Emma Fields", "Scott Guzman", "Olivia Alexander", "Kelly Garrett", "Jesse Hanson", "Henry Wong", "Billy Vasquez",
            "Larry Ramirez", "Bryan Brooks", "Alan Berry", "Nicole Powell", "Stephen Bowman", "Eric Hughes", "Elizabeth Obrien", "Timothy Ramos",
            "Michelle Russell", "Denise Ruiz", "Sean Carter", "Amanda Barnett", "Kathy Black", "Terry Gutierrez", "John Jensen", "Grace Sanchez",
            "Tiffany Harvey", "Jacqueline Sims", "Wayne Lee", "Roy Foster", "Joyce Hart", "Joseph Russell", "Harold Washington", "Beverly Cox",
            "Nicole Morales", "Anna Carpenter", "Jesse Ray", "Ann Snyder", "Mark Diaz", "Elizabeth Harper", "Andrew Guerrero", "Cheryl Silva",
            "Michelle Hudson", "Jeffrey Santos", "Victoria Vasquez", "Matthew Meyer", "Jacob Murray", "Jose Munoz", "Edward Howell", "Vincent Hunter",
            "Daniel Walters", "Samantha Obrien", "Laura Elliott", "Richard Olson", "Daniel Graham", "Carol Lee", "Grace Sullivan", "Nancy Rodriguez",
            "Tyler Tran", "Crystal Shaw", "Madison Allen", "Ralph Sims", "Joe Jenkins", "Dennis Ray", "Arthur Davidson", "Victoria Allen", "Arthur Jackson",
            "Joan Thomas", "Daniel Hopkins", "Gloria Hicks", "Danielle Price", "Craig Keller", "Alan Morgan", "Gregory Silva", "Samantha Kelly",
            "Rachel Williamson", "Bruce Garrett", "Jacob Smith", "Kathleen Nichols", "Sarah Long", "Carol Pearson", "Virginia Mendez", "Judy Valdez",
            "Jason Garza", "Brenda Fowler", "Karen Edwards", "Alexander Anderson", "Pamela Wallace", "Ruth Howell", "Walter Hernandez", "George Lucas",
            "Samantha Long", "Margaret Garza", "Kathleen Schultz", "Frances Guerrero", "Amber Meyer", "Rachel Morales", "Teresa Curtis", "Heather Bell",
            "Grace Johnson", "Melissa King", "Zachary Cook", "Carol Schultz", "Jane Beck", "Karen Stone", "Roger Brooks", "Carolyn Fuller", "Nicholas Coleman",
            "William Bishop", "Christine May", "Linda George", "Jean Meyer", "Cheryl Armstrong", "Danielle Welch", "Amanda Graham", "Janice Carter",
            "Catherine Brooks", "Lawrence Gonzalez", "Amy Russell", "Eugene Jimenez", "Joseph Carlson", "Peter McCoy", "Jerry Washington", "Carolyn Obrien",
            "Mark Walker", "Stephanie Hoffman", "Julie Pena", "Karen Curtis", "Bryan Cruz", "Madison Shaw", "Rachel Graham", "Susan Simpson", "Andrea Harrison",
            "Bryan Miller", "Vincent McDonald", "Jesse McCoy", "Christine Ramos", "Dorothy Riley", "Karen Warren", "Ashley Weber", "Judith Robinson",
            "Alan Mendez", "Donna Medina", "Helen Lane", "Douglas Clark", "Brenda Romero", "Doris Wells", "Patrick Howell", "Doris Lawrence", "Harry Jacobs",
            "Phillip Rose", "Deborah Patel", "Bryan Day", "Rachel Butler", "Paul Butler", "Judy Knight", "Willie Wallace", "Phillip Anderson", "Emma Black",
            "Lisa Lynch", "Kimberly Freeman", "Ronald West", "Kathleen Harris", "Martha Ruiz", "Phillip Moreno", "Robert Vargas", "Jesse Diaz", "Christine Weber",
            "Karen Stanley", "Theresa Edwards", "Kathryn Chavez", "Sarah Rios", "Danielle Wong", "Kathy Carr", "Joan Diaz", "Albert Walters",
            "Denise Kim", "Katherine Pearson", "Diana Richardson", "Harry Ford", "Eric Mills", "Sean Hicks", "Joe Brown", "Judith Morgan", "Harry Hunter",
            "Matthew Bryant", "Tyler Rose", "Mildred Delgado", "Emma Peters", "Walter Delgado", "Lauren Gilbert", "Christopher Romero"
        ];

        users = users.map(function (fullName) {
            var userName = fullName.replace(/ /g, '').toLowerCase();

            return {
                id: userName,
                name: userName,
                fullName: fullName
            }
        });

        users = users.filter(function (user) {
            return user.name.indexOf(query.term) === 0
        });

        success(users)
    };

    var table = '<p>This table uses features of the non-editable plugin to make the text in the<br /><strong>top row</strong> and <strong>left column</strong> uneditable.</p>' +
        '    <table style="width: 60%; border-collapse: collapse;" border="1"> ' +
        '        <caption class="mceNonEditable">Ephox Sales Analysis</caption> ' +
        '       <tbody> ' +
        '          <tr class="mceNonEditable"> ' +
        '                <th style="width: 40%;">&nbsp;</th><th style="width: 15%;">Q1</th> ' +
        '                <th style="width: 15%;">Q2</th><th style="width: 15%;">Q3</th> ' +
        '                <th style="width: 15%;">Q4</th> ' +
        '            </tr> ' +
        '            <tr> ' +
        '                <td class="mceNonEditable">East Region</td> ' +
        '                <td>100</td> <td>110</td> <td>115</td> <td>130</td> ' +
        '            </tr> ' +
        '            <tr> ' +
        '                <td class="mceNonEditable">Central Region</td> ' +
        '                <td>100</td> <td>110</td> <td>115</td> <td>130</td> ' +
        '            </tr> ' +
        '            <tr> ' +
        '                <td class="mceNonEditable">West Region</td> ' +
        '                <td>100</td> <td>110</td> <td>115</td> <td>130</td> ' +
        '            </tr> ' +
        '        </tbody> ' +
        '    </table>';

    var table2 = '<div> ' +
        '        <p>' +
        '            Templates are a great way to help content authors get started creating content.  You can define the HTML for the template and ' +
        '            then when the author inserts the template they have a great start towards creating content! ' +
        '        </p> ' +
        '        <p> ' +
        '            In this example we create a simple table for providing product details for a product page on your web site.  The headings are ' +
        '            made non-editable by loading the non-editable plugin and placing the correct class on the appropriate table cells. ' +
        '        </p> ' +
        '        <table style="width:90%; border-collapse: collapse;" border="1"> ' +
        '        <tbody> ' +
        '        <tr style="height: 30px;"> ' +
        '            <th class="mceNonEditable" style="width:40%; text-align: left;">Product Name:</td><td style="width:60%;">{insert name here}</td> ' +
        '        </tr> ' +
        '        <tr style="height: 30px;"> ' +
        '            <th class="mceNonEditable" style="width:40%; text-align: left;">Product Description:</td><td style="width:60%;">{insert description here}</td> ' +
        '        </tr> ' +
        '        <tr style="height: 30px;"> ' +
        '            <th class="mceNonEditable" style="width:40%; text-align: left;">Product Price:</td><td style="width:60%;">{insert price here}</td> ' +
        '        </tr> ' +
        '        </tbody> ' +
        '        </table> ' +
        '    </div> ';

    var demoBaseConfig = {
        selector: "textarea#textarea",
        //width: 755,
        height: 400,
        resize: false,
        autosave_ask_before_unload: false,
        mentions_fetch: mentionsFetchFunction,
        powerpaste_allow_local_images: true,
        plugins: [
            "a11ychecker advcode advlist anchor autolink codesample fullscreen help image imagetools tinydrive",
            " lists link media noneditable powerpaste preview",
            " searchreplace table template tinymcespellchecker visualblocks wordcount mentions"
        ],
        templates: [
            {
                title: "Non-editable Example",
                description: "Non-editable example.",
                content: table
            },
            {
                title: "Simple Table Example",
                description: "Simple Table example.",
                content: table2
            }
        ],
        toolbar:
            "insertfile a11ycheck undo redo | bold italic underline | forecolor backcolor | template codesample | alignleft aligncenter alignright alignjustify | " +
            "bullist numlist | link image media | preview fullscreen",
        content_css: [
            "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
            "//www.tiny.cloud/css/content-standard.min.css"
        ],
        <?php
        $media_query = "SELECT * FROM media ORDER BY id DESC";
        $media_run = mysqli_query($connectionDB, $media_query);
        if (mysqli_num_rows($media_run) > 0){
        ?>
        image_list: [
            <?php
            while ($media_row = mysqli_fetch_array($media_run)){
            $media_image = $media_row["image"];
            ?>
            {title: '<?php echo $media_image; ?>', value: 'uploads/media/<?php echo $media_image; ?>'},
            <?php }?>
        ]<?php }?>,
        spellchecker_dialog: true,
        spellchecker_whitelist: ['Ephox', 'Moxiecode'],
        tinydrive_demo_files_url: '/docs/demo/tiny-drive-demo/demo_files.json',
        tinydrive_token_provider: function (success, failure) {
            success({token: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqb2huZG9lIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Ks_BdfH4CWilyzLNk8S2gDARFhuxIauLa8PwhdEQhEo'});
        }
    };

    tinymce.init(demoBaseConfig);
</script>

<!-- Prevent form resubmission when page is refreshed -->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<!-- Prevent form resubmission when page is refreshed -->
</body>

</html>