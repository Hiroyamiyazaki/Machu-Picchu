<?php


  session_start();

  require('dbconnect.php');
  require('function.php');

  const CONTENT_PER_PAGE = 8;



  if(isset($_SESSION['id'])) {

    $signin_user = get_user($dbh, $_SESSION['id']);

  }





//ページネーション　１２件取得する

  // 何ページ目を開いているかを取得
   if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

 // -1などのページ数として不正な値を渡された場合の対策
    $page = max($page, 1);

    $last_page = get_last_page($dbh);

    $start = ($page - 1) * CONTENT_PER_PAGE;







    $sql = 'SELECT `feeds`.*, `users`.`user_id`  as name, `relations`.`relation_name`, `events`.`event_name`, `ages`.`generation`, `jobs`.`job_name` FROM `feeds` LEFT JOIN `users` ON `feeds`.`user_id` = `users`.id  LEFT JOIN `relations` ON `relations`.`id` = `relation_id` LEFT JOIN `events` ON `events`.`id`= `event_id` LEFT JOIN `ages` ON `ages`.`id` = `feeds`.`age_id` LEFT JOIN `jobs` ON `jobs`.`id` = `feeds`.`job_id` ORDER BY `created` DESC LIMIT '. CONTENT_PER_PAGE .' OFFSET ' . $start;

    $data = [];

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

        if(isset($_SESSION['id'])) {
        
            $rec["is_liked"] = is_liked($dbh, $signin_user['id'], $rec["id"]);

        } else {

            $rec["is_liked"] = false;
        }

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
    <title>Premori! -Top-</title>
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

    <link rel="stylesheet"  href="assets/css/index.css">


</head>
<body>
<div class="loader">
    <div class="loader-outter"></div>
    <div class="loader-inner"></div>
</div>

<div class="body-container container-fluid ">
    <a class="menu-btn" href="javascript:void(0)">
        <i class="ion ion-grid"></i>
    </a>
    <div class="row justify-content-center">
        <?php include('nav.php'); ?>

        <!--=================== content body ====================-->
        <div class="col-lg-10 col-md-9 col-12 body_block  main-contents">
            <div class="container-fluid back">
                <div class="img_card">

                    <!-- content-explain -->
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12 col-xs-12 top-wrapper1">

                            <img src="assets/img/main_img.jpg" class="top_img">
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-12 col-xs-12 top-wrapper2">
                                <img src="assets/img/uses/main_5.png" class="top_img2">
                        </div>
                        <div class="col-lg-6 col-md-12 col-xs-12 top-wrapper3">
                            <h3 class="intro">Premori!って？</h3>
                            <div class="tape">
                            <div class="paper">
                                <P>いつ誰に何をもらったのかを、<br>
                                    記録として残したり、<br>
                                    お仕事に使ったり、<br>
                                あの日の思い出を残しておくことができます。</P>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-12 col-xs-12 top-wrapper3">
                            <div class="tape">
                            <div class="paper">
                                <p>誰かの思い出を辿って<br>
                                    あなたの大切な人への思い出を<br>
                                プレゼントすることができます。</p>
                            </div>
                            </div><br><br><br>
                            <div class="tape">
                            <div class="paper">
                                <p>あなたの立場、<br>
                                    お相手の年代・職業、イベントから<br>
                                喜ばれるプレゼントを探してみましょう。</p>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-xs-12 top-wrapper4">
                            <img src="assets/img/uses/main_4.png" class="top_img3">
                        </div>
                    </div>


                    <!-- content-explain end -->




                    <div class="col-lg-12 col-md-12 col-xs-12 top-wrapper5">
                        <div class="memo">
                            <span class="masking-tape"></span>
                            <h2>プレゼント一覧</h2>
                        </div>
                    </div>

                    <div class="portfolio gutters grid img-container conbo">
                        <span hidden class="signin_user"><?= $signin_user["id"] ?></span>


                        <?php foreach ($allfeeds as $allfeed): ?>


                            <div class="grid-sizer col-sm-12 col-md-6 col-lg-3"></div>
                            <div class="grid-item branding  col-sm-12 col-md-6 col-lg-3 feed_con">
                                <a class="popup-modal" href="#inline-wrap<?php echo $allfeed["id"] ?>"><img src="./assets/img/post_img/<?php echo $allfeed['img_name'] ?>" class="img_g card bgWhite flip flipAnimation"></a>
                                <div id="inline-wrap<?php echo $allfeed["id"] ?>" class="mfp-hide hoge">

                                    <div class="image"><img src="./assets/img/post_img/<?php echo $allfeed['img_name'] ?>"></div><br>
                                    <p class="date_rec"><?php echo date('Y.m.d', strtotime($allfeed['date'])) ?></p>



                                    <div class="modal_btn">
                                    <!-- いいね機能 -->
                                    <?php  if(isset($_SESSION['id']) && $allfeed["user_id"]==$_SESSION["id"]): ?>

                                        <i class="fa fa-heart fa-2x" aria-hidden="true"></i>
                                        <span class="like_count"><?= $allfeed['like_cnt'] ?></span>

                                        <?php elseif(isset($_SESSION['id'])): ?>

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

                                            <span class="like_count"><?= $allfeed['like_cnt'] ?></span>

                                            <?php else: ?>

                                            <i class="fa fa-heart fa-xs" aria-hidden="true"></i>
                                            <span class="like_count"><?= $allfeed['like_cnt'] ?></span>

                                        <?php endif; ?>
                                        <!-- いいね機能end -->


                                        <!-- コメント機能 -->
                                        <?php  if(isset($_SESSION['id']) && $allfeed["user_id"]==$_SESSION["id"]): ?>

                                            <i class="fa fa-comment fa-2x"></i>
                                            <span class="comment_count btn_text"><?= $allfeed["comment_cnt"] ?></span><br><br>


                                            <?php  elseif(isset($_SESSION['id'])): ?>

                                                <a href="#collapseComment<?= $allfeed["id"] ?>" data-toggle="collapse" aria-expanded="false">
                                                    <i class="fa fa-comment fa-2x"></i>
                                                </a>
                                                <span class="comment_count btn_text"><?= $allfeed["comment_cnt"] ?></span><br><br>

                                            <?php else: ?>

                                                <i class="fa fa-comment fa-2x"></i>
                                                <span class="comment_count btn_text"><?= $allfeed["comment_cnt"] ?></span><br><br>

                                          <?php endif; ?>
                                        <!-- コメント機能end -->
                                    </div><br><br><br>



                                                 <!-- 投稿内容 -->
                                                        <p><?php echo $allfeed['relation_name']; ?> / <?php echo $allfeed['event_name']; ?></p>
                                                        <p><?php echo $allfeed['feed']; ?></p>
                                                        <?php if(isset($_SESSION['id']) && $allfeed["user_id"]==$_SESSION["id"]): ?>
                                                            <p><?php echo $allfeed['secret_feed']; ?></p>
                                                        <?php endif; ?>
                                                        <p class="user_info"><?php echo $allfeed['name']; ?> / <?php echo $allfeed['generation']; ?> / <?php echo $allfeed['gender']; ?></p>
                                                <!-- 投稿内容end -->


                                                <!-- 編集削除ボタン -->
                                                        <div class="btn_user">
                                                            <?php if(isset($_SESSION['id']) && $allfeed["user_id"]==$_SESSION["id"]): ?>
                                                                <a href="edit.php?feed_id=<?php echo $allfeed["id"] ?>" class="btn btn-success btn-sm">編集</a>
                                                                <a onclick="return confilm('ほんとに消すの？');" href="delete.php?feed_id=<?php echo $allfeed["id"] ?>" class="btn btn-danger btn-sm">削除</a>
                                                            <?php endif; ?>
                                                            <?php include("comment_view.php"); ?>
                                                        </div>
                                                <!-- 編集削除end -->


                                                    </div>
                                                </div>

                                            <?php endforeach; ?>
                                        </div>



                                        <!--=================== filter portfolio end====================-->
                                        <div class="col-lg-12 col-md-12 col-xs-12 top-wrapper4">
                                            <div class="sub-contents">
                                                <!-- 新しい投稿ページに戻る（前に戻る） -->
                                                <?php if($page == 1): ?>
                                                    <li class="previous disabled"><a><span aria-hidden="true">&larr;</span>
                                                        <button type="button" class="btn btn-primary btn-lg">前に戻る</button></a>
                                                    </li>
                                                    <?php else: ?>
                                                        <li class="previous"><a href="index.php?page=<?php echo $page -1; ?>"><span aria-hidden="true">&larr;</span>
                                                            <button type="button" class="btn btn-primary btn-lg">前に戻る</button></a>
                                                        </li>
                                                    <?php endif; ?>
                                                </div>

                                                　　　　　　　　　　　　　<!-- 古い投稿に進む（もっと見る） -->
                                                <div class="sub-contents">
                                                    <?php if($page == $last_page): ?>
                                                        <li class="next disabled"><a><span aria-hidden="true">&larr;</span>
                                                            <button type="button" class="btn btn-primary btn-lg">もっと見る</button></a>
                                                        </li>
                                                        <?php else: ?>
                                                            <li class="next"><a href="index.php?page=<?php echo $page +1; ?>"><span aria-hidden="true">&larr;</span>
                                                                <button type="button" class="btn btn-primary btn-lg">もっと見る</button></a>
                                                            </li>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>


        </div>
    </div>
</div>
        <!--=================== content body end ====================-->


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