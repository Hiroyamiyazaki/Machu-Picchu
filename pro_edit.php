<?php

  session_start();

  require('dbconnect.php');
  require('function.php');



  $signin_user = get_user($dbh, $_SESSION['id']);



  if(!isset($_SESSION['id'])) {
    header('Location:signup.php');
    exit();
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
    <link href="assets/css/main.css" rel="stylesheet">
        <!-- Custom by us -->
    <link rel="stylesheet"  href="assets/css/style.css">

    <link rel="stylesheet"  href="assets/css/pro_edit.css">
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
                        <h3>プロフィール編集</h3>

                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-12 top-wrapper1">
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

                        <div class="form-group">
                            <label for="name" class="control-label col-sm-2">年代</label>
                                <div class="col-sm-10">
                                    <input type="text" name="input_age_id" class="form-control" id="name" placeholder="20代" value = "<?php echo htmlspecialchars($age_id); ?>">
                                    <!-- issetは入っているかどうか -->
                                    <?php if (isset($errors['age_id']) && $errors['age_id'] == 'blank'):?>
                                        <p class = "text-danger">年代を入力してください</p>
                                    <?php endif; ?>
                                </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label col-sm-2">性別</label>
                                <div class="col-sm-10">
                                    <input type="text" name="input_gender" class="form-control" id="name" placeholder="女性" value = "<?php echo htmlspecialchars($gender); ?>">
                                    <!-- issetは入っているかどうか -->
                                    <?php if (isset($errors['gender']) && $errors['age_id'] == 'blank'):?>
                                        <p class = "text-danger">性別を入力してください</p>
                                    <?php endif; ?>
                                </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label col-sm-2">職業</label>
                                <div class="col-sm-10">
                                    <input type="text" name="input_job_id" class="form-control" id="name" placeholder="OL" value = "<?php echo htmlspecialchars($job_id); ?>">
                                    <?php if (isset($errors['job_id']) && $errors['job_id'] == 'blank'):?>
                                        <p class = "text-danger">職業を入力してください</p>
                                    <?php endif; ?>
                                </div>
                        </div>

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
                </div>s

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