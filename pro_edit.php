<?php

  session_start();

  require('dbconnect.php');
  require('function.php');



  $signin_user = get_user($dbh, $_SESSION['id']);



  if(!isset($_SESSION['id'])) {
    header('Location:signup.php');
    exit();
  }


  //SQL文を作る
    $sql = "SELECT * FROM `users` WHERE `id` = ?";
    //?の代わりになるdataを入れる
    $data = array($signin_user['id']);
    //準備する
    $stmt = $dbh->prepare($sql);
    //実行する　（）の中に?の代わりにれるdataをかく
    $stmt->execute($data);

    $profile = $stmt->fetch(PDO::FETCH_ASSOC);


// 選択ボタン 年代

    $ages = what_age($dbh);
    $jobs = what_job($dbh);

 







// 編集
    if (!empty($_POST)) {
    $update_sql = "UPDATE `users` SET `user_id`=?, `age_id`=?, `gender`=?, `job_id`=?, `brands`=? WHERE `users`.`id` = ?";
    $data = array($_POST['input_user_id'], $_POST['input_age'], $_POST['input_gender'], $_POST['input_job'], $_POST['input_brands'], $profile['id']);
    $stmt = $dbh->prepare($update_sql);
    $stmt->execute($data);


    header("Location: pro_edit.php");
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
            
            <header class="row justify-content-center">
                  <div class="col-lg-12 col-md-12 col-xs-12 sub-contents1">
                        <h2 class="pro_title">プロフィール編集</h2>
                 </div>
            </header>


            <div class="col-lg-12 col-md-12 col-12">
            <form method="POST" action="pro_edit.php" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group">
                            <label for="name" class="control-label col-sm-2">ID</label>
                            <div class="col-sm-12">
                                <input type="text" name="input_user_id" class="form-control" id="name" placeholder="プレモリ君" value = "<?php echo htmlspecialchars($profile['user_id']); ?>">
                                    <?php if (isset($errors['user_id']) && $errors['user_id'] == 'blank'):?>
                                        <p class = "text-danger">IDを入力してください</p>
                                    <?php endif; ?>
                            </div>
                         </div>

                        <div class="form-group">
                            <label for="name" class="control-label col-sm-2">年代</label>
                                <div>
                                    <select name="input_age">
                                         <option value="age">--- 年代 ---</option>
                                            <?php foreach ($ages as $age): ?>
                                                    <option value="<?php echo $age['id']; ?>"
                                                        <?php if($age['id'] == $profile['age_id']) { echo 'selected'; } ?>
                                                        >
                                                        <?php echo $age['generation']; ?>
                                                   </option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                                    <?php if (isset($errors['age_id']) && $errors['age_id'] == 'blank'):?>
                                        <p class = "text-danger">年代を入力してください</p>
                                    <?php endif; ?>
                                </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label col-sm-2">性別</label>
                                <div class="col-sm-10">
                                    <select name="input_gender">
                                        <option value="gender">--- 性別 ---</option>
                                        <option>男性</option>
                                        <option>女性</option>
                                    </select>
                                    <!-- issetは入っているかどうか -->
                                    <?php if (isset($errors['gender']) && $errors['age_id'] == 'blank'):?>
                                        <p class = "text-danger">性別を入力してください</p>
                                    <?php endif; ?>
                                </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label col-sm-2">職業</label>
                                 <div>
                                    <select name="input_job">
                                        <option value="job">--- 職業 ---</option>
                                            <?php foreach($jobs as $job): ?>
                                                <option value="<?php echo $job['id']; ?>"
                                                    <?php if($job['id'] == $profile['job_id']) {
                                                    echo 'selected'; } ?>
                                                    >
                                                    <?php echo $job['job_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($errors['job_id']) && $errors['job_id'] == 'blank'):?>
                                        <p class = "text-danger">職業を入力してください</p>
                                    <?php endif; ?>
                                </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label col-sm-3">好きなもの</label>
                                <div class="col-sm-12">
                                    <input type="text" name="input_brands" class="form-control" id="name" placeholder="" value = "<?php echo htmlspecialchars($profile['brands']); ?>">
                                    <?php if (isset($errors['brands']) && $errors['brands'] == 'blank'):?>
                                        <p class = "text-danger">好きなものを入力してください</p>
                                    <?php endif; ?>
                                </div>
                        </div>


                        <div class="form-group btn-submit">
                            <input type="submit" class="btn btn-primary btnn" value="確認">
                        </div>
                    </form>
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
</body>
</html>