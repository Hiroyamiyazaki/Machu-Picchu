<?php


require('dbconnect.php');
require_once('function.php');

//ドロップダウンリストに表示
//相手欄
$sql = 'SELECT * FROM `relations`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$relations = array();

while (1) {
    $record =$stmt->fetch(PDO::FETCH_ASSOC);
    if($record==false){
        break;
    }
    $relations[] = $record;
}
//年代欄
$sql = 'SELECT * FROM `ages`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$ages = array();

while (1) {
    $agerec =$stmt->fetch(PDO::FETCH_ASSOC);
    if($agerec==false){
        break;
    }
    $ages[] = $agerec;
}
//職業欄を表示
$sql = 'SELECT * FROM `jobs`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$jobs = array();

while (1) {
    $jobrec =$stmt->fetch(PDO::FETCH_ASSOC);
    if($jobrec==false){
        break;
    }
    $jobs[] = $jobrec;
}

//イベント欄
$sql = 'SELECT * FROM `events`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$events = array();

while (1) {
    $eventrec =$stmt->fetch(PDO::FETCH_ASSOC);
    if($eventrec==false){
        break;
    }
    $events[] = $eventrec;
}

//選択したものの表示をsearch.phpに引き継ぐ
$select_relation = '';
$select_age = '';
$select_job = '';
$select_event = '';

if(isset($_GET['relation'])){
    $select_relation = $_GET['relation'];
}
if (isset($_GET['age'])){
    $select_age = $_GET['age'];
}
if (isset($_GET['job'])) {
    $select_job = $_GET['job'];
}
if (isset($_GET['event'])) {
    $select_event = $_GET['event'];
}


?>


<link rel="stylesheet"  href="assets/css/nav.css">


<!--=================== side menu ====================-->
<div class="col-lg-2 col-md-3 col-12 menu_block">
            <!--logo -->
            <div class="logo_box">
                <a href="#">
                    <img src="assets/img/main-logo.png" class="main_logo" alt="Premori!">
                </a>
            </div><br>
            <!--logo end-->


    <!-- profile -->
    <?php if(isset($_SESSION['id'])): ?>
        <div class="profilearea">
            <ul class="menu_nav pro_nav">
                <li>
                    <span class="user_id">ID:<?php echo $signin_user['user_id']; ?></span>
                </li><br><br>
                <li>
                    <a href="mypage.php">
                        マイページ
                    </a>
                </li>
                <li>
                    <a href="like_page.php">
                        いいね！
                    </a>
                </li>
                <li>
                    <a href="pro_edit.php">
                        プロフィール編集
                    </a>
                </li>
                <li>
                    <a href="signout.php">
                        ログアウト
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>

    <!-- profile end -->

    <!--main menu -->
    <div class="side_menu_section">
        <ul class="menu_nav">
            <li class="active">
                <a href="index.php">
                    ホーム
                </a>
            </li>
            <?php if(!isset($_SESSION['id'])): ?>
                <li>
                    <a href="signin.php">
                        ログイン
                    </a>
                </li>
                <li>
                    <a href="signup.php">
                        アカウント登録
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="search.php">
                    投稿一覧
                </a>
            </li>
            <li>

                <a href="search.php">
                    更新
                </a>
            </li>
        </ul>
    </div>
    <!--main menu end -->

    <br>


    <!-- search menu -->
    <div class="search_box">
        <ul class="s_nav">
            <li class="active">
                <h5>検索</h5>
            </li>
            <li>

                <div>
                    <form method="GET" action="search.php" class="navbar-form navbar-left" role="search">
                        <!-- relation -->
                        <div>
                            <select name="relation">
                                <option value="">--- あなたは？ ---</option>
                                <?php foreach($relations as $relation): ?>
                                    <option value="<?php echo $relation['id']; ?>"
                                        <?php if($relation['id'] == $select_relation) { echo 'selected'; } ?>
                                    >
                                        <?php echo $relation['relation_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                            <!-- ages generation-->
                            <div>
                                <select name="age">
                                     <option value="">--- お相手の年代 ---</option>
                                        <?php foreach ($ages as $age): ?>
                                                <option value="<?php echo $age['id']; ?>"
                                                    <?php if($age['id'] == $select_age) { echo 'selected'; } ?>
                                                    >
                                                    <?php echo $age['generation']; ?>
                                               </option>
                                        <?php endforeach; ?>
                                </select>
                            </div>

                                <!-- jobs -->
                                <div>
                                    <select name="job">
                                        <option value="">--- お相手の職業 ---</option>
                                            <?php foreach($jobs as $job): ?>
                                                <option value="<?php echo $job['id']; ?>"
                                                    <?php if($job['id'] == $select_job) {
                                                    echo 'selected'; } ?>
                                                    >
                                                    <?php echo $job['job_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>

                                    <!-- events -->
                                    <div>
                                        <select name="event">
                                                <option value="">---イベント---</option>
                                                <?php foreach($events as $event): ?>
                                                       <option value="<?php echo $event['id']; ?>"
                                                        <?php if($event['id'] ==$select_event) {
                                                            echo 'selected';} ?>
                                                            >
                                                            <?php echo $event['event_name']; ?>
                                                        </option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>

                                        <button class="btn btn-primary btn-lg">検索</button>
                    </form>
                </div>



            </li>
        </ul>

    </div>
                    <!-- search menu end -->




                    <!--social and copyright -->
                    <div class="side_menu_bottom">
                        <div class="side_menu_bottom_inner">
                            <ul class="social_menu">
                                <li>
                                    <a href="https://www.instagram.com/"> <i class="ion ion-social-instagram"></i> </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/"> <i class="ion ion-social-facebook"></i> </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/"> <i class="ion ion-social-twitter"></i> </a>
                                </li>
                            </ul>
                            <div class="copy_right">
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                <p class="copyright">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            </div>
                        </div>
                    </div>
                    <!--social and copyright end -->

                </div>
<!--=================== side menu end====================-->