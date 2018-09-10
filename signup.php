<?php
    session_start();

    require('dbconnect.php');
    require('function.php');

    date_default_timezone_set('Asia/Manila');

    // PHPプログラム
    $user_id = '';
    $age_id = '';
    $gender = '';
    $job_id = '';
    $brands = '';
    $errors = [];
    //getにactionというキーが存在するか、そのactionの中にrewriteが存在するのか、check.phpから戻ってきているのかの確認
    if (isset($_GET['action']) && $_GET['action'] == 'rewrite'){
        $_POST['input_user_id'] = $_SESSION['register']['user_id'];
        $_POST['input_age_id'] = $_SESSION['register']['age_id'];
        $_POST['input_gender'] = $_SESSION['register']['gender'];
        $_POST['input_job_id'] = $_SESSION['register']['job_id'];
        $_POST['input_brands'] = $_SESSION['register']['brands'];
        $_POST['input_password'] = $_SESSION['register']['password'];

        $errors['rewrite'] = true;
    }


// var_dump($_POST); die();

    if (!empty($_POST)){
        $user_id = $_POST['input_user_id'];
        $age_id = $_POST['input_age_id'];
        $gender = $_POST['input_gender'];
        $job_id = $_POST['input_job_id'];
        $brands = $_POST['input_brands'];
        $password = $_POST['input_password'];

        // ユーザー名の空チェック
        // シングルクォーテーション''=空じゃなければ
        if ($user_id == ''){
            $errors['user_id'] = 'blank';
        }
        // ユーザー名の空チェック
        // シングルクォーテーション''=空じゃなければ

        if ($age_id == ''){
            $errors['age_id'] = 'blank';
        }
        if ($gender ==''){
            $errors['gender'] = 'blank';
        }
        if ($job_id == ''){
            $errors['job_id'] = 'blank';
        }
        if ($brands == ''){
            $errors['brands'] = 'blank';
        }

        if ($password == ''){
            $errors['password'] = 'blank';
        }
        $count = strlen($password);
        if ($password == ''){
            $errors['password'] = 'blank';
        }elseif ($count < 4 || 16 < $count){
            $errors['password'] = 'length';
        }

        //画像名を取得
        //undifined index連想配列が定義されていない
        //もしパラメーターが存在していなければ、ユーザーが送った画像が表示される。
        // $file_name = '';
        // if (!isset($_GET['action'])){
        //     $file_name = $_FILES['input_img_name']['name'];
        // }
        // //画像が送られてきた場合
        // if (!empty($file_name)){
        //     $file_type = substr($file_name, -3);//画像名の後ろから3文字取得
        //     $file_type = strtolower($file_type);//大文字が含まれていた場合全て小文字化
        //     if ($file_type != 'jpg' && $file_type != 'png' && $file_type != 'gif'){
        //         $errors['img_name'] = 'type';
        //     }
        //     //拡張子チェックの処理
        // }else{
        //     $errors['img_name'] = 'blank';
        // }

        if (empty($errors)){
            $date_str = date('YmdHis');
            $submit_file_name = $date_str.$file_name;
            //ここで画像をアップデート先に移す
            move_uploaded_file($_FILES['input_img_name']['tmp_name'], '../user_profile_img/'.$submit_file_name);
            // $errorsが空だった場合はバリデーション成功
            //成功時の処理を記述する

            //セッションに変数を入れる

            $_SESSION['register']['user_id'] = $_POST['input_user_id'];
            $_SESSION['register']['password'] = $_POST['input_password'];
            $_SESSION['register']['age_id'] = $_POST['input_age_id'];
            $_SESSION['register']['gender'] = $_POST['input_gender'];
            $_SESSION['register']['job_id'] = $_POST['input_job_id'];
            $_SESSION['register']['brands'] = $_POST['input_brands'];

            header('Location: check.php');
            exit();
        }


       

    }


     $ages = what_age($dbh);

     $jobs = what_job($dbh);





    // $hoge = '';
    // カラかどうかのチェック
    // (empty($hoge))
    // 変数が存在するかどうかのチェック
    // (isset($hoge))
    // empty = !isset

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

         <link rel="stylesheet"  href="assets/css/register.css">
    </head>
    <body style="margin-top: 60px">
        <div class="container">
            <div class="row justify-content-center">
                <!-- ここにコンテンツ -->
                <!-- ここから -->
                <div class="col-ld-12 col-md-12 col-xs-12">
                    <div class="sub-contents1">
                            <img class="reg_title" src="assets/img/main-logo.png">
                            <p class="intro">あの日のプレゼントを思い出に。<br>
                               そしてまた誰かの思い出に。</p>
                        </div>
                </div>
                <div class="col-ld-12 col-md-12 col-xs-12">
                    <form method="POST" action="signup.php" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group">
                            <label for="name" class="control-label col-sm-2">ID</label>
                            <div class="col-sm-10">
                                <input type="text" name="input_user_id" class="form-control" id="name" placeholder="プレモリ君" value = "<?php echo htmlspecialchars($user_id); ?>">
                                    <?php if (isset($errors['user_id']) && $errors['user_id'] == 'blank'):?>
                                        <p class = "text-danger">IDを入力してください</p>
                                    <?php endif; ?>
                            </div>
                         </div>

                        <div class="form-group">
                            <label for="name" class="control-label col-sm-2">Pass</label>
                                <div class="col-sm-10">
                                    <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
                                    <?php if (isset($errors['password']) && $errors['password'] == 'blank'):?>
                                        <p class = "text-danger">パスワードを入力してください</p>
                                    <?php endif; ?>
                                    <?php if (isset($errors['password']) && $errors['password'] == 'length'):?>
                                        <p class = "text-danger">4 ~ 16文字のパスワードを入力してください</p>
                                    <?php endif; ?>
                                    <!-- もし$errorsが空じゃなければエラーメッセージを出力する -->
                                    <?php if(!empty($errors)): ?> <p class = "text-danger">パスワードを再度入力して下さい</p> <?php endif; ?>
                                </div>
                        </div>

                        <p>年代</p>
                            <select name="input_age_id">
                                <option value="age">--- 年代 ---</option>
                                <?php foreach($ages as $age): ?>
                                    <option value="<?php echo $age['id']; ?>">
                                        <?php echo $age['generation']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php if (isset($errors['input_age_id']) && $errors['input_age_id'] == 'blank'): ?>
                                <p class="text-danger">年代を選んでください</p>
                            <?php endif; ?>

                        <p>性別</p>
                                <select name="input_gender">
                                    <option value="gender">--- 性別 ---</option>
                                    <option>男性</option>
                                    <option>女性</option>
                                </select>
                            <?php if (isset($errors['input_gender']) && $errors['input_gender'] == 'blank'): ?>
                                    <p class="text-danger">性別を選んでください</p>
                                <?php endif; ?>

                        <p>職業</p>
                            <select name="input_job_id">
                                <option value="age">--- 職業 ---</option>
                                <?php foreach($jobs as $job): ?>
                                    <option value="<?php echo $job['id']; ?>">
                                        <?php echo $job['job_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php if (isset($errors['input_job_id']) && $errors['input_job_id'] == 'blank'): ?>
                                <p class="text-danger">年代を選んでください</p>
                            <?php endif; ?>

                        
                        <div class="form-group">
                            <label for="name" class="control-label col-sm-3">好きなもの</label>
                                <div class="col-sm-10">
                                    <input type="text" name="input_brands" class="form-control" id="name" placeholder="" value = "<?php echo htmlspecialchars($brands); ?>">
                                    <?php if (isset($errors['brands']) && $errors['brands'] == 'blank'):?>
                                        <p class = "text-danger">好きなものを入力してください</p>
                                    <?php endif; ?>
                                </div>
                        </div>


                        <div class="form-group btn-submit">
                            <input type="submit" class="btn btn-primary " value="確認">
                            <a href="signin.php" class="btn btn-primary">サインイン</a>
                        </div>
                    </form>
                </div>
            <!-- ここまで -->

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