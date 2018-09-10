    <?php
    //初期化
    //バリデーション処理
        require('dbconnect.php');
        //$errors = array();

        $errors = [];
        session_start();

        if (!empty($_POST)){
            $user_id = $_POST["input_user_id"];
            $password = $_POST["input_password"];

            if($user_id != '' && $password !=''){
                $sql = 'SELECT*FROM `users` WHERE `user_id`=?';
                $data = [$user_id];
                $stmt = $dbh->prepare($sql);
                $stmt->execute($data);
                $record = $stmt->fetch(PDO::FETCH_ASSOC);

            //メールアドレスで本人確認
                if ($record == false){
                    $errors['signin'] = 'failed';
                }
                //左側がユーザーが打ったパスワード、右側はデータベースにあるパスワード。２つがうまく認証できるのか確認
                if (password_verify($password,$record['password'])){
                    //認証成功
                    //SESSION変数にIDを保存
                    $_SESSION['id'] = $record['id'];

                    //timeline.phpに移動
                    header("Location: mypage.php");
                }else{
                    //認証失敗
                    $errors['signin'] = 'failed';
                }
                //データベースとの照合
            }else{
                $errors['signin'] = 'blank';
            }
            //echo '通過テスト' . '<br>';
        }
    ?>
    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="utf-8">
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

        <link rel="stylesheet" href="assets/css/register.css">

    </head>
    <body style="margin-top: 60px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="sub-contents1 col-ld-6 col-md-12 col-xs-12">
                        <img class="reg_title" src="assets/img/main-logo.png">
                </div>
                <div class="col-ld-6 col-md-12 col-xs-12">
                    <div class="log_con">
                        <h2 class="text-center content_header">ログイン</h2>
                    </div>

                    <form method="POST" action="" enctype="multipart/form-data">
                         <?php if(isset($errors['signin']) && $errors['signin'] == 'blank'): ?>
                                <p class="text-danger">IDとパスワードを正しく入力してください</p>
                                <?php endif; ?>
                                <?php if(isset($errors['signin']) && $errors['signin'] == 'failed'): ?>
                                    <p class = "text-danger">サインインに失敗しました</p>
                                <?php endif; ?>
                        <div class="form-group">
                            <label for="name" class="control-label col-sm-2 label_name">ID</label>
                                <div class="col-sm-12 col-sm-offset-1">
                                    <input type="text" name="input_user_id" class="form-control t_form" id="name" placeholder="">
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label col-sm-2 label_name">Pass</label>
                                <div class="col-sm-12 col-sm-offset-1">
                                    <input type="password" name="input_password" class="form-control t_form" id="password" placeholder="4 ~ 16文字のパスワード">
                                </div>
                        </div>
                        <div class="btn-submit">
                            <input type="submit" class="btn btn-info btnn" value="ログイン">
                            <a href="signup.php" class="btn btn-primary btnn">登録</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


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
