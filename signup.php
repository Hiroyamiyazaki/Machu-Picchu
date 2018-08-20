<?php
    session_start();

    date_default_timezone_set('Asia/Manila');

    // PHPプログラム
    $user_id = '';
    $age_id = '';
    $job_id = '';
    $brands = '';
    $errors = [];
    //getにactionというキーが存在するか、そのactionの中にrewriteが存在するのか、check.phpから戻ってきているのかの確認
    if (isset($_GET['action']) && $_GET['action'] == 'rewrite'){
        $_POST['input_user_id'] = $_SESSION['register']['user_id'];
        $_POST['input_age_id'] = $_SESSION['register']['age_id'];
        $_POST['input_job_id'] = $_SESSION['register']['job_id'];
        $_POST['input_brands'] = $_SESSION['register']['brands'];
        $_POST['input_password'] = $_SESSION['register']['password'];

        $errors['rewrite'] = true;
    }

    if (!empty($_POST)){
        $user_id = $_POST['input_user_id'];
        $age_id = $_POST['input_age_id'];
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
            $_SESSION['register']['age_id'] = $_POST['input_gender'];
            $_SESSION['register']['job_id'] = $_POST['input_job_id'];
            $_SESSION['register']['brands'] = $_POST['input_brands'];

            header('Location: check.php');
            exit();
        }
    }
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
                <h2 class="text-center content_header">思い出を残そう</h2>
                <form method="POST" action="signup.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xs-3">
                            <label for="name">ID</label>
                        </div>
                        <div class="col-xs-9">
                            <div class="form-group">
                                <input type="text" name="input_user_id" class="form-control" id="name" placeholder="プレモリ君" value = "<?php echo htmlspecialchars($user_id); ?>">
                                <?php if (isset($errors['user_id']) && $errors['user_id'] == 'blank'):?>
                                    <p class = "text-danger">IDを入力してください</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3">
                            <label for="name">Pass</label>
                        </div>
                        <div class="col-xs-9">
                    <div class="form-group">
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
            </div>

            <div class="row">
                <div class="col-xs-3">
                    <label for="name">年代</label>
                </div>
                        <div class="col-xs-9">
                    <div class="form-group">
                        <input type="text" name="input_age_id" class="form-control" id="name" placeholder="20代" value = "<?php echo htmlspecialchars($age_id); ?>">
                        <!-- issetは入っているかどうか -->
                        <?php if (isset($errors['age_id']) && $errors['age_id'] == 'blank'):?>
                            <p class = "text-danger">年代を入力してください</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-3">
                    <label for="name">職業</label>
                </div>
                <div class="col-xs-9">
                    <div class="form-group">
                        <input type="text" name="input_job_id" class="form-control" id="name" placeholder="OL" value = "<?php echo htmlspecialchars($job_id); ?>">
                        <?php if (isset($errors['job_id']) && $errors['job_id'] == 'blank'):?>
                            <p class = "text-danger">職業を入力してください</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row submit_center">
                <div class="col-xs-3">
                    <label for="name">好きなもの</label>
                </div>
                <div class="col-xs-9">
                    <div class="form-group">
                        <input type="text" name="input_brands" class="form-control" id="name" placeholder="" value = "<?php echo htmlspecialchars($brands); ?>">
                        <?php if (isset($errors['brands']) && $errors['brands'] == 'blank'):?>
                            <p class = "text-danger">好きなものを入力してください</p>
                        <?php endif; ?>
                    </div>
                    <input type="submit" class="btn btn-default-cente btn-lg" style="position:absolute;left:50%; right:50%; width:180px; "value="確認"></div>
                </div>
            </div> 
                    <a href="signin.php" style="float: right; padding-top: 6px;" class="text-success">サインイン</a>
                </form>
            </div>
            <!-- ここまで -->

            </div>
        </div>
        <script src="../Machu-Picchu/assets/js/jquery-3.1.1.js"></script>
        <script src="../Machu-Picchu/assets/js/jquery-migrate-1.4.1.js"></script>
        <script src="../Machu-Picchu/assets/js/bootstrap.js"></script>
    </body>
</html>