<?php
    session_start();
    //ここでdbconnectを呼ぶ
    require_once('dbconnect.php');

//以下のregisterはsignup.phpでセッションに変数を入れている
    if (!isset($_SESSION['register'])){
        header('Location: signup.php');
        exit();
    }

    //出力テスト
    //多次元配列、配列の中に配列が入っている
    //今回は、registerの中にnameなどが入っている
    $user_id = $_SESSION['register']['user_id'];
    $password = $_SESSION['register']['password'];
    $age_id = $_SESSION['register']['age_id'] ;
    $gender = $_SESSION['register']['gender'] ;    
    $job_id = $_SESSION['register']['job_id'] ;
    $brands = $_SESSION['register']['brands'] ;

    var_dump($gender);

 
    if (!empty($_POST)){
        $sql = 'INSERT INTO `users` SET `user_id`=?, `password`=?, `age_id`=?, `gender`=?, `job_id`=?, `brands`=?, `created`=NOW()';
        $data = array($user_id, password_hash($password,PASSWORD_DEFAULT), $age_id, $gender, $job_id, $brands);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        //セッションは次のページに行っても残り続けるから、unsetで終わりにする。ポストでは必要ない。
        unset($_SESSION['register']);
        header('Location: thanks.php');
        exit();

        //この中のデータベース登録処理を記述します
        //echo '通過テスト' . '<br>';
    }
    // PHPプログラム
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Premori</title>
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

        <link rel="stylesheet" type="text/css" href="assets/css/register.css">

    </head>
    <body style="margin-top: 60px">
        <div class="container">
            <div class="row justify-content-center">
                <!-- ここにコンテンツ -->
                <!-- ここから -->
                <div class="col-ld-12 col-md-12 col-xs-12 log_con">
                    <h2 class="text-center content_header">これでいい?</h2>
                        <div class="form-group">
                            <span class="control-label col-sm-2">ID</span>
                            <div class="col-sm-10">
                                <p class="lead"><?php echo htmlspecialchars($user_id); ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="control-label col-sm-2">パスワード</span>
                            <div class="col-md-10">
                                <p class="lead">●●●●●●●●</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="control-label col-sm-2">年代</span>
                            <div class="col-md-10">
                                <p class="lead"><?php echo htmlspecialchars($age_id); ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="control-label col-sm-2">性別</span>
                            <div class="col-md-10">
                                <p class="lead"><?php echo htmlspecialchars($gender); ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="control-label col-sm-2">職業</span>
                            <div class="col-md-10">
                                <p class="lead"><?php echo htmlspecialchars($job_id); ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="control-label col-sm-2">好きなもの</span>
                            <div class="col-md-10">
                                <p class="lead"><?php echo htmlspecialchars($brands); ?></p>
                            </div>
                        </div>

                    <!-- ③ -->
                    <form method="POST" action="" class="btn-sub2">
                        <!-- ④ -->
                        <!-- action=rewriteが付いている場合は、check.phpから戻ってきたと判断する -->
                        <a href="signup.php?action=rewrite" class="btn btn-primary btn-lg btnn">&laquo;&nbsp;戻る</a>
                        <!-- ⑤ -->
                        <input type="hidden" name="action" value="submit">
                        <input type="submit" class="btn btn-primary btn-lg btnn" value="登録">
                    </form>

                </div>
            </div>
        </div>
        <!-- ここまで -->

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