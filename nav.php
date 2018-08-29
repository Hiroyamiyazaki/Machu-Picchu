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
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">相手<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <?php foreach($relations as $relation) {?>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><?php echo $relation['relation_name']; ?></a></li>
                                <?php } ?>

                            </ul>

                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">年代<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <?php foreach ($ages as $age) { ?>

                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><?php echo $age['generation']; ?></a></li>
                            <?php } ?>

                            </ul>

                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">職業<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">OL</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">妻</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">学生</a></li>
                            </ul>

                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">イベント<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">記念日</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">誕生日</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">クリスマス</a></li>
                            </ul>

                            <button type="button" class="btn btn-primary btn-lg"><a href='search.php'>検索</a></button>
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