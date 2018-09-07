<?php

  session_start();

  require('dbconnect.php');
  require('function.php');



  $signin_user = get_user($dbh, $_SESSION['id']);



  if(!isset($_SESSION['id'])) {
    header('Location:signup.php');
    exit();
  }

//     //何ページ目を開いているか決める
// if (isset($_GET[‘page’])) {
//    $page = $_GET[‘page’];
// } else {
//    $page = 1;
// }






    $sql = 'SELECT `feeds`.*, `users`.`user_id`  as name, `users`.`gender`, `users`.`age_id`, `users`.`job_id`, `relations`.`relation_name`, `events`.`event_name`, `ages`.`generation`, `jobs`.`job_name` FROM `feeds` LEFT JOIN `users` ON `feeds`.`user_id` = `users`.id  LEFT JOIN `relations` ON `relations`.`id` = `relation_id` LEFT JOIN `events` ON `events`.`id`= `event_id` LEFT JOIN `ages` ON `ages`.`id` = `age_id` LEFT JOIN `jobs` ON `jobs`.`id` = `job_id`  WHERE `feeds`.`user_id` = ? ORDER BY `created` ASC';



    $data = array($signin_user['id']);

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $allfeeds = array();

    
    while (1) {
    // データを１件ずつ取得
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
           break;
        }



        $rec["like_cnt"] = count_like($dbh, $rec["id"]);

        $rec["is_liked"] = is_liked($dbh, $signin_user['id'], $rec["id"]);

        $rec["comments"] = get_comment($dbh, $rec["id"]);

        $rec["comment_cnt"] = count_comment($dbh, $rec["id"]);



    $allfeeds[] = $rec;


}




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
    <title> MyPage</title>


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
    <link rel="stylesheet"  href="assets/css/mypage.style.css">
    <link rel="stylesheet"  href="assets/css/index.css">
    <!-- ページネーション作成のため、moc index.php を参照しました。 -->
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
        <div class="col-lg-10 col-md-9 col-12 body_block  align-content-center body_con">

            <header>
                    <div class="col-lg-12 col-md-12 col-12 top-wrapper1">
                        <div class="sub-contents1">
                            <h2 class="my_title">マイページ</h2>
                            <a href="post.php" class="b_post">
                                <span class="img_icon"><i class="fa fa-camera-retro fa-5x"></i></span>
                            </a>
                        </div>
                    </div>
            </header>
            <!--=================== filter portfolio start====================-->
            <div class="portfolio gutters grid img-container">

                <?php foreach ($allfeeds as $allfeed): ?>


                    <div class="grid-sizer col-sm-12 col-md-6 col-lg-3"></div>
                    <div class="grid-item branding  col-sm-12 col-md-6 col-lg-3 feed_con">
                        <a class="popup-modal" href="#inline-wrap<?php echo $allfeed["id"] ?>"><img src="./assets/img/post_img/<?php echo $allfeed['img_name'] ?>" class="img_g"></a>
                        <div id="inline-wrap<?php echo $allfeed["id"] ?>" class="mfp-hide hoge">
                            <div class="image"><img src="./assets/img/post_img/<?php echo $allfeed['img_name'] ?>"></div><br>
                            <p class="date_rec"><?php echo date('Ymd', strtotime($allfeed['date'])) ?></p>

                            <span hidden class="feed-id"><?= $allfeed["id"] ?></span>
                            <?php if($allfeed['is_liked']): ?>
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
                                <span class="like_count"><?= $allfeed['like_cnt'] ?></span>

                                <a href="#collapseComment<?= $allfeed["id"] ?>" data-toggle="collapse" aria-expanded="false">
                                    <i class="fa fa-comment"></i>
                                    <span>コメントする</span>
                                </a>
                                <span class="comment_count btn_text">コメント数 : <?= $allfeed["comment_cnt"] ?></span><br><br>

                                <p><?php echo $allfeed['relation_name']; ?> / <?php echo $allfeed['event_name']; ?></p>
                                <p><?php echo $allfeed['feed']; ?></p>
                                <p><?php echo $allfeed['secret_feed']; ?></p>
                                <p class="user_info"><?php echo $allfeed['name']; ?> / <?php echo $allfeed['generation']; ?> / <?php echo $allfeed['gender']; ?></p>



                                <div class="btn_user">
                                    <a href="edit.php?feed_id=<?php echo $allfeed["id"] ?>" class="btn btn-success btn-sm">編集</a>
                                    <a onclick="return confilm('ほんとに消すの？');" href="delete.php?feed_id=<?php echo $allfeed["id"] ?>" class="btn btn-danger btn-sm">削除</a>
                                    <?php include("comment_view.php"); ?> 
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>


            </div>

            <!--=================== filter portfolio end====================-->
            <div class="col-lg-12 col-md-12 col-xs-12 top-wrapper4">
                <div class="sub-contents">
                     <button type="button" class="btn btn-primary btn-lg">もっと見る</button>
                </div>
            </div>
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