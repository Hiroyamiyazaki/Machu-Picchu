<?php


require('dbconnect.php');
require_once('function.php');


//相手欄のドロップダウンリストに表示
$sql = 'SELECT * FROM `relations`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$relations = array();



while (1) {
# code...
    $record =$stmt->fetch(PDO::FETCH_ASSOC);
    if($record==false){
        break;
    }
    $relations[] = $record;
}


//年代欄のドロップダウンリストに表示
$sql = 'SELECT * FROM `ages`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$ages = array();

while (1) {
# code...
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
# code...
    $jobrec =$stmt->fetch(PDO::FETCH_ASSOC);
    if($jobrec==false){
        break;
    }
    $jobs[] = $jobrec;
}

//イベント欄に表示
$sql = 'SELECT * FROM `events`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$events = array();

while (1) {
# code...
    $eventrec =$stmt->fetch(PDO::FETCH_ASSOC);
    if($eventrec==false){
        break;
    }
    $events[] = $eventrec;
}

// search feedsを取得
$spl = 'SELECT * FROM `feeds` WHERE `age_id` =? AND `f`.`relation_id` =? AND `job_id` =? AND `event_id` =?';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$select_relation = "";
$select_age = "";
$select_job = "";
$select_event = "";

if (!empty($_GET)) {
    $select_relation = $_GET['relation'];
    $select_age = $_GET['age'];
    $select_job = $_GET['job'];
    $select_event = $_GET['event'];
}

$sql = "";

$data = array();


$is_search_all = empty($_GET['relation']) && empty($_GET['age']) && empty($_GET['job']) && empty($_GET['event']);

if ($is_search_all) {
    $sql = 'SELECT `f`.* FROM `feeds` AS `f` ORDER BY `f`.`created` DESC';
} else {

    $relation = '';
    $age = '';
    $job = '';
    $event = '';
    $sql = 'SELECT * FROM `feeds` WHERE ';

    // １relationが真
    // ２relationが選択されていない->真の場合＝＝ageを検索、偽の場合==relationとageの両方を検索
    // ３relationが選択されていない+ageが選択されていない->真の場合==jobを検索、偽の場合==relationかjobを検索
    //条件 ? 条件が正しかった場合　：　条件が正しくなかった場合
    if (!empty($_GET['relation'])) {
        $relation = '`relation_id` = ?';
        $sql .= $relation;
        $data[] = $_GET['relation'];
    }

    if (!empty($_GET['age'])) {
        $age = '`age_id` = ?';
        $sql .= $relation == '' ? $age : ' AND ' . $age;
        $data[] = $_GET['age'];
    }

    if (!empty($_GET['job'])) {
        $job = '`job_id` = ?';
        $sql .= $relation == '' && $age == '' ? $job : ' AND ' . $job;
        $data[] = $_GET['job'];
    }

    if (!empty($_GET['event'])) {
        $event = '`event_id` =?';
        $sql .= $relation == '' && $age == '' && $job == '' ? $event : ' AND ' . $event;
        $data[] = $_GET['event'];
    }

    $order_by = ' ORDER BY `created` DESC';
    $sql .= $order_by;

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

}

//表示用の配列を初期化
$feeds = array();

while (true) {
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if($record  == false){
    break;
    }
    $feeds[] = $record;

}


?>


<link rel="stylesheet"  href="assets/css/nav.css">


<!--=================== side menu ====================-->
<div class="col-lg-2 col-md-3 col-12 menu_block">
            <!--logo -->
            <div class="logo_box">
                <a href="#">
                    <img src="assets/img/main-logo.png" alt="Premori!">
                </a>
            </div>
            <!--logo end-->


    <!-- profile -->
    <?php if(isset($_SESSION['id'])): ?>
        <div class="profilearea">
            <ul class="menu_nav pro_nav">
                <li>
                    <span class="user_id">ID:<?php echo $signin_user['user_id']; ?></span>
                </li>
                <li>
                    <a href="mypage.php">
                        My page
                    </a>
                </li>
                <li>
                    <a href="pro_edit.php">
                        Profile編集
                    </a>
                </li>
                <li>
                    <a href="signout.php">
                        Sign out
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
                    Home
                </a>
            </li>
            <?php if(!isset($_SESSION['id'])): ?>
                <li>
                    <a href="signin.php">
                        Login
                    </a>
                </li>
                <li>
                    <a href="signup.php">
                        Register
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="search.php">
                    Album
                </a>
            </li>
            <li>

                <a href="search.php">
                    Update
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
                <h5>Search</h5>
            </li>
            <li>

                <div>
                    <form method="GET" action="search.php" class="navbar-form navbar-left" role="search">
                        <!-- relation -->
                        <div>
                            <select name="relation">
                                <option value="">--- 相手 ---</option>
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
                                     <option value="">--- 年代 ---</option>
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
                                        <option value="">--- 職業 ---</option>
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
                                    <a href="#"> <i class="ion ion-social-pinterest"></i> </a>
                                </li>
                                <li>
                                    <a href="#"> <i class="ion ion-social-facebook"></i> </a>
                                </li>
                                <li>
                                    <a href="#"> <i class="ion ion-social-twitter"></i> </a>
                                </li>
                                <li>
                                    <a href="#"> <i class="ion ion-social-dribbble"></i> </a>
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