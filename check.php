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
    $job_id = $_SESSION['register']['job_id'] ;
    $brands = $_SESSION['register']['brands'] ;

    if (!empty($_POST)){
        $sql = 'INSERT INTO `users` SET `user_id`=?, `password`=?, `age_id`=?, `job_id`=?, `brands`=?, `created`=NOW()';
        $data = array($user_id, password_hash($password,PASSWORD_DEFAULT));
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
        <link rel="stylesheet" type="text/css" href="../Machu-Picchu/assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../Machu-Picchu/assets/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="../Machu-Picchu/assets/css/register.css">

    </head>
    <body style="margin-top: 60px">
        <div class="container">
            <div class="row">
                    <!-- ここにコンテンツ -->
                    <!-- ここから -->
            <div class="col-xs-8 col-xs-offset-2 thumbnail">
                <h2 class="text-center content_header">これでいい?</h2>
                <div class="row">
                    <div class="col-xs-3">
                        <span>ID</span>
                    </div>
                    <div class="col-xs-9">
                        <div class="form-group">
                            <p class="lead"><?php echo htmlspecialchars($user_id); ?></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-3">
                        <span>パスワード</span>
                    </div>
                    <div class="col-xs-9">
                        <div class="form-group">
                        <p class="lead">●●●●●●●●</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-3">
                        <span>年代</span>
                    </div>
                    <div class="col-xs-9">
                        <div class="form-group">
                            <p class="lead"><?php echo htmlspecialchars($age_id); ?></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-3">
                        <span>職業</span>
                    </div>
                    <div class="col-xs-9">
                        <div class="form-group">
                            <p class="lead"><?php echo htmlspecialchars($job_id); ?></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-3">
                        <span>好きなもの</span>
                    </div>
                    <div class="col-xs-9">
                        <div class="form-group">
                            <p class="lead"><?php echo htmlspecialchars($brands); ?></p>
                        </div>
                    </div>
                </div>

                        <!-- ③ -->
                        <form method="POST" action="">
                            <!-- ④ -->
                            <!-- action=rewriteが付いている場合は、check.phpから戻ってきたと判断する -->
                            <a href="signup.php?action=rewrite" class="btn btn-default-cente btn-lg" style="position:absolute;left:20%; right:80%; width:180px; ">&laquo;&nbsp;戻る</a>
                            <!-- ⑤ -->
                            <input type="hidden" name="action" value="submit">
                            <input type="submit" class=btn btn-default-cente btn-lg" style="position:absolute;left:50%; right:50%; width:180px; " value="登録">
                        </form>

                    </div>
                </div>
            </div>
            <!-- ここまで -->
            </div>
        </div>
        <script src="../Machu-Picchu/assets/js/jquery-3.1.1.js"></script>
        <script src="../Machu-Picchu/assets/js/jquery-migrate-1.4.1.js"></script>
        <script src="../Machu-Picchu/assets/js/bootstrap.js"></script>
    </body>
</html>