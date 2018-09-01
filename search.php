<?php



  session_start();

  require('dbconnect.php');
  require('function.php');


  $signin_user = get_user($dbh, $_SESSION['id']);







//投稿取得
    $sql = 'SELECT `feeds`.*, `users`.`user_id`  as name, `users`.`gender`, `users`.`age_id`, `users`.`job_id` FROM `feeds` LEFT JOIN `users` ON `feeds`.`user_id` = `users`.id ORDER BY `created` ASC';


    $data = [];

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);


    $feeds = array();
    while (1) {
    // データを１件ずつ取得
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
           break;
        }


        $rec["like_cnt"] = count_like($dbh, $rec["id"]);

        $rec["is_liked"] = is_liked($dbh, $signin_user['id'], $rec["id"]);


    $feeds[] = $rec;


}

// var_dump($rec); die();

  ?>




<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta name="description" content="Cocoon -Portfolio">
    <meta name="keywords" content="Cocoon , Portfolio">
    <meta name="author" content="Pharaohlab">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- ========== Title ========== -->
    <title> Premori! 検索</title>
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
    <link rel="stylesheet"  href="assets/css/search.style.css">
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
        <div class="col-lg-10 col-md-9 col-12 body_block  align-content-center search_padding">

            <header>
                <h2>検索「           」</h2>
            </header>
            <!--=================== filter portfolio start====================-->
            <div class="portfolio gutters grid img-container">


                <?php foreach ($feeds as $feed): ?>


                    <div class="grid-sizer col-sm-12 col-md-6 col-lg-3"></div>
                    <div class="grid-item branding  col-sm-12 col-md-6 col-lg-3 feed_con">
                        <a class="popup-modal" href="#inline-wrap<?php echo $feed["id"] ?>"><img src="./assets/img/post_img/<?php echo $feed['img_name'] ?>" class="img_g"></a>
                        <div id="inline-wrap<?php echo $feed["id"] ?>" class="mfp-hide hoge">
                            <div class="image"><img src="./assets/img/post_img/<?php echo $feed['img_name'] ?>"></div><br>
                            <p class="date_rec"><?php echo date('Ymd', strtotime($feed['date'])) ?></p>

                            <span hidden class="feed-id"><?= $feed["id"] ?></span>
                            <?php if($feed['is_liked']): ?>
                                <button class="btn btn-info btn-sm js-unlike">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    <span>いいねを取り消す</span>
                                </button>
                                <?php else: ?>
                                    <button class="btn btn-info btn-sm js-like">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                        <span>いいね!</span>
                                    </button>
                                <?php endif; ?>
                                <span>いいね数 : </span>
                                <span class="like_count"><?= $feed['like_cnt'] ?></span>

                                <a href="#collapseComment<?= $feed["id"] ?>" data-toggle="collapse" aria-expanded="false">
                                    <i class="fa fa-comment"></i>
                                    <span>コメントする</span>
                                </a>
                                <span class="comment_count btn_text">コメント数 : 9</span><br><br>

                                <p><?php echo $feed['relation_id']; ?> / <?php echo $feed['event_id']; ?></p>
                                <p><?php echo $feed['feed']; ?></p>
                                <p class="user_info"><?php echo $feed['name']; ?> / <?php echo $feed['age_id']; ?> / <?php echo $feed['gender']; ?></p>


                                <div class="btn_user">
                                <?php if($feed["user_id"]==$_SESSION["id"]): ?>
                                    <a href="edit.php?feed_id=<?php echo $feed["id"] ?>" class="btn btn-success btn-sm">編集</a>
                                    <a onclick="return confilm('ほんとに消すの？');" href="delete.php?feed_id=<?php echo $feed["id"] ?>" class="btn btn-danger btn-sm">削除</a>
                                <?php endif; ?>
                                    <?php include("comment_view.php"); ?> 
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>
            <!--=================== filter portfolio end====================-->
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

<script src="assets/js/app.js"></script>
</body>
</html>