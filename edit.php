<?php


    session_start();
    require('dbconnect.php');
    require('function.php');


    $signin_user = get_user($dbh, $_SESSION['id']);



  if(!isset($_SESSION['id'])) {
    header('Location:signup.php');
    exit();
  }


    $feed_id = $_GET["feed_id"];



    $sql = "SELECT `feeds`.*, `users`.`user_id` as name, `users`.`gender`, `users`.`age_id`, `users`.`job_id` FROM `feeds` LEFT JOIN `users` ON `feeds`.`user_id` = `users`.id WHERE `feeds`.`id` = $feed_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $feed = $stmt->fetch(PDO::FETCH_ASSOC);





    if (!empty($_POST)) {
        $update_sql = "UPDATE `feeds` SET `feed` = ? WHERE `feeds`.`id` = ?";
        $data = array($_POST["feed"],$feed_id);
        $stmt = $dbh->prepare($update_sql);
        $stmt->execute($data);

        header("Location: mypage.php");
        exit();
    }









?>





<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta name="description" content="Cocoon -Portfolio">
    <meta name="keywords" content="Cocoon , Portfolio">
    <meta name="author" content="Pharaohlab">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- ========== Title ========== -->
    <title></title>
    <!-- ========== Favicon Ico ========== -->
    <!--<link rel="icon" href="fav.ico">-->
    <!-- ========== STYLESHEETS ========== -->
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonts Icon CSS -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/et-line.css" rel="stylesheet">
    <link href="assets/css/ionicons.min.css" rel="stylesheet">
    <!-- Carousel CSS -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!-- Magnific-popup -->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">
        <!-- Custom by us -->
    <link rel="stylesheet"  href="assets/css/style.css">

    <link rel="stylesheet"  href="assets/css/post.css">

</head>
<body>
<div class="loader">
    <div class="loader-outter"></div>
    <div class="loader-inner"></div>
</div>

<div class="body-container container-fluid">
    <a class="menu-btn" href="javascript:void(0)">
        <i class="ion ion-grid"></i>
    </a>
    <div class="row justify-content-center">
        <?php include('nav.php'); ?>

        <!--=================== content body ====================-->
        <div class="col-lg-10 col-md-9 col-12 body_block  align-content-center">

            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-12 top-wrapper1">
                    <div class="sub-contents">
                        <h3>Post</h3>
                    </div>
                </div>
            </div>

            <form method="POST" action="" enctype="multipart/form-data">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-12 col-xs-12 top-wrapper2">
                         <div class="sub-contents">
                            <img src="assets/img/uses/index_top2.jpg" class="top_img2">
                         </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-xs-12 top-wrapper3">
                          <div class="sub-contents2">
                             <h2>Post</h2><br>
                             <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" name="date" class="form-control" value="<?php echo $feed['date']; ?>">
                            </div><br>

                            <p>相手<br>
                            <select name="relation_id">
                                <option value="A">友人</option>
                                <option value="B">B型</option>
                                <option value="O">O型</option>
                                <option value="AB">AB型</option>
                            </select></p>
                            <?php if (isset($errors['relation_id']) && $errors['relation_id'] == 'blank'): ?>
                                    <p class="text-danger">相手を選んでください</p>
                                <?php endif; ?>
                           
                           <p>イベント<br>
                            <select name="event_id">
                                <option value="A">記念日</option>
                                <option value="B">B型</option>
                                <option value="O">O型</option>
                                <option value="AB">AB型</option>
                            </select></p>
                                <?php if (isset($errors['event_id']) && $errors['event_id'] == 'blank'): ?>
                                    <p class="text-danger">イベントを選んでください</p>
                                <?php endif; ?>
                            </div><br><br>
                            <div class="form-group">
                                <label for="img_name">Photo</label><br>
                                <input type="file" name="input_img_name" id="img_name" value="<?php echo $feed['img_name']; ?>">
                            </div>
                    </div>
                 </div>

                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-12 top-wrapper4">
                        <div class="sub-contents">
                            <div class="form-group">
                                <label for="feed">Comment</label><br>
                                <textarea name="feed" class="form-comment"rows="6"><?php echo htmlspecialchars($feed['feed']); ?></textarea>

                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-12 top-wrapper5">
                        <div class="sub-contents">
                            <div class="form-group">
                                <label for="secret_feed">Secret Comment</label><br>
                                <textarea name="secret_feed" class="form-comment" rows="6"><?php echo htmlspecialchars($feed['secret_feed']); ?></textarea>

                             </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-xs-12 top-wrapper6">
                    <div class="sub-contents">
                            <!-- ④ -->
                        <a href="post.php?action=rewrite" class="btn btn-primary">&laquo;&nbsp;Back</a> | 
                            <!-- ⑤ -->
                        <input type="hidden" name="action" value="submit">
                        <input type="submit" class="btn btn-primary" value="投稿">
                    </div>
                </div>
            </form>

        </div>
        <!--=================== content body end ====================-->
    </div>
</div>



<!-- jquery -->
<script src="assets/js/jquery.min.js"></script>
<!-- bootstrap -->
<script src="assets/js/popper.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/waypoints.min.js"></script>
<!--slick carousel -->
<script src="assets/js/slick.min.js"></script>
<!--Portfolio Filter-->
<script src="assets/js/imgloaded.js"></script>
<script src="assets/js/isotope.js"></script>
<!-- Magnific-popup -->
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<!--Counter-->
<script src="assets/js/jquery.counterup.min.js"></script>
<!-- WOW JS -->
<script src="assets/js/wow.min.js"></script>
<!-- Custom js -->
<script src="assets/js/main.js"></script>
</body>
</html>