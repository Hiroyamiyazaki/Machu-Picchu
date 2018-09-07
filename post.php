<?php


    session_start();
    require('dbconnect.php');
    require('function.php');


    date_default_timezone_set("Asia/Manila");



    //サインインユーザー取得

    $signin_user = get_user($dbh, $_SESSION['id']);



    if(!isset($_SESSION['id'])) {
        header('Location:signup.php');
        exit();
    }



    $date = '';
    $relation_id = '';
    $event_id = '';
    $feed = '';
    $secret_feed = '';
    $errors = array();



// var_dump($_POST); die();



// もしも空じゃなかったらPOST送信
     if (!empty($_POST)) {

        $date = ($_POST['date']);
        $relation_id = htmlspecialchars($_POST['relation_id']);
        $event_id = htmlspecialchars($_POST['event_id']);
        $feed = htmlspecialchars($_POST['feed']);
        $secret_feed = htmlspecialchars($_POST['secret_feed']);




        // もしも空だったらエラーメッセージ
            if ($date == '') {
                $errors['date'] = 'blank';
            }

            if ($relation_id == '') {
                $errors['relation_id'] = 'blank';
            }

            if ($event_id == '') {
                $errors['event_id'] = 'blank';
            }





       // 画像挿入
        $file_name = '';
        if (!isset($_GET['action'])) {
            $file_name = $_FILES['input_img_name']['name'];
            }



        if (!empty($file_name)) {
            $file_type = substr($file_name, -4);  //画像名の後ろから4文字を取得
            $file_type = strtolower($file_type);  //大文字が含まれていた場合全て小文字化
            if ($file_type != '.jpg' && $file_type != '.png' && $file_type != '.gif' && $file_type != 'jpeg') {
                $errors['img_name'] = 'type';
            }
        } else {
           $errors['img_name'] = 'blank';
        }


        if (empty($errors)) {
        //$errorsが空だった場合はバリデーション成功
        //成功時の処理を記述する
        $date_str = date('YmdHis');
        $submit_file_name = $date_str.$file_name;
        // move_uploaded_file（テンポラリパス、保存したい場所、ファイル名）
        move_uploaded_file($_FILES['input_img_name']['tmp_name'], './assets/img/post_img/'.$submit_file_name);



        $_SESSION['hoge']['date'] = $_POST['date'];
        $_SESSION['hoge']['relation_id'] = $_POST['relation_id'];
        $_SESSION['hoge']['event_id'] = $_POST['event_id'];
        $_SESSION['hoge']['feed'] = $_POST['feed'];
        $_SESSION['hoge']['secret_feed'] = $_POST['secret_feed'];
        $_SESSION['hoge']['img_name'] = $submit_file_name;


        create_feed($dbh, $date, $relation_id, $event_id, $submit_file_name, $feed, $secret_feed, $signin_user['id'], $signin_user['gender'], $signin_user['age_id'], $signin_user['job_id']);


        header('Location: mypage.php');
        exit();

        }



    }



//投稿ボタン

        $relations = who_relation($dbh);

        $events = what_event($dbh);






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
                    <div class="sub-contents1">
                        <h2 class="post_title">Post</h2>
                    </div>
                </div>
            </div>

            <form method="POST" action="" enctype="multipart/form-data">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-12 col-xs-12 top-wrapper2">
                         <div class="sub-contents">
                            <p  class="preview" id="preview1"></p>
                         </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-xs-12 top-wrapper3">
                          <div class="sub-contents2">
                             <h2>Post</h2><br>
                             <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" name="date" class="form-control" value="<?php echo $date; ?>">
                            </div><br>

                            <p>相手</p>
                                <select name="relation_id">
                                    <option value="relation">--- 相手 ---</option>
                                    <?php foreach($relations as $relation): ?>
                                        <option value="<?php echo $relation['id']; ?>">
                                            <?php echo $relation['relation_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php if (isset($errors['relation_id']) && $errors['relation_id'] == 'blank'): ?>
                                    <p class="text-danger">相手を選んでください</p>
                                <?php endif; ?>
                           
                           <p>イベント<br>
                             <select name="event_id">
                                <option value="event">---イベント---</option>
                                    <?php foreach($events as $event): ?>
                                        <option value="<?php echo $event['id']; ?>"><?php echo $event['event_name']; ?></option>
                                    <?php endforeach; ?>
                                        </select>
                                <?php if (isset($errors['event_id']) && $errors['event_id'] == 'blank'): ?>
                                    <p class="text-danger">イベントを選んでください</p>
                                <?php endif; ?>
                            </div><br><br>
                            <div class="form-group">
                                <label for="img_name">Photo</label><br>
                                <input type="file" name="input_img_name" id="img_name" value="<?php echo $submit_file_name; ?>">
                                <?php if(isset($errors['img_name']) && $errors['img_name'] =='blank') { ?>
                                    <p class="text-danger">画像を選択してください</p>
                                 <?php } ?>
                                <?php if (isset($errors['img_name']) && $errors['img_name'] == 'type'): ?>
                                    <p class="text-danger">"jpg", "png", "gif"の画像を画像を選択して下さい</p>
                                <?php endif; ?>
                            </div>
                    </div>
                 </div>

                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-12 top-wrapper4">
                        <div class="sub-contents">
                            <div class="form-group">
                                <label for="feed">Comment</label><br>
                                <textarea name="feed" cols="50" rows="6"><?php echo htmlspecialchars($feed); ?></textarea>

                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-12 top-wrapper5">
                        <div class="sub-contents">
                            <div class="form-group">
                                <label for="secret_feed">Secret Comment</label><br>
                                <textarea name="secret_feed" cols="50" rows="6"><?php echo htmlspecialchars($secret_feed); ?></textarea>

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

<script src="assets/js/jquery.upload_thumbs.js"></script>
<script src="assets/js/app.js"></script>


</body>
</html>