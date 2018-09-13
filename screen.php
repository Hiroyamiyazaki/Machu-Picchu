<!-- <<<<<<< HEAD
                <?php foreach ($allfeeds as $index => $allfeed): ?>
                    <?php if ($index % 4 == 0): ?>
                        <?php echo '<div class="row col-lg-12">' ?>
                    <?php endif; ?>



                    <div class="grid-sizer grid-item branding  col-sm-3 col-md-3 col-lg-3 feed_con">
                        <a class="popup-modal" href="#inline-wrap<?php echo $allfeed["id"] ?>"><img src="./assets/img/post_img/<?php echo $allfeed['img_name'] ?>" class="img_g"></a>
                        <div id="inline-wrap<?php echo $allfeed["id"] ?>" class="mfp-hide hoge">
                            <div class="image"><img src="./assets/img/post_img/<?php echo $allfeed['img_name'] ?>"></div><br>
                            <p class="date_rec"><?php echo date('Ymd', strtotime($allfeed['date'])) ?></p>

                            <span hidden class="feed-id"><?= $allfeed["id"] ?></span>
                            <?php if($allfeed['is_liked']): ?>
                                <button class="btn btn-info btn-sm js-unlike">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    <span>いいねを取り消す</span>
                                </button>
                                <?php else: ?>
                                    <button class="btn btn-info btn-sm js-like">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                        <span>いいね!</span>
                                    </button>
                                <?php endif; ?>
                                <span>いいね数 : </span>
                                <span class="like_count"><?= $allfeed['like_cnt'] ?></span>

                                <a href="#collapseComment<?= $allfeed["id"] ?>" data-toggle="collapse" aria-expanded="false">
                                    <i class="fa fa-comment"></i>
                                    <span>コメントする</span>
                                </a>
                                <span class="comment_count btn_text">コメント数 :<?= $allfeed["comment_cnt"] ?></span><br><br>

                                <p><?php echo $allfeed['relation_name']; ?> / <?php echo $allfeed['event_name']; ?></p>
                                <p><?php echo $allfeed['feed']; ?></p>
                                <?php if($allfeed["user_id"]==$_SESSION["id"]): ?>
                                <p><?php echo $allfeed['secret_feed']; ?></p>
                                <?php endif; ?>
                                <p class="user_info"><?php echo $allfeed['name']; ?> / <?php echo $allfeed['generation']; ?> / <?php echo $allfeed['gender']; ?></p>


                                <div class="btn_user">
                                <?php if($allfeed["user_id"]==$_SESSION["id"]): ?>
                                    <a href="edit.php?feed_id=<?php echo $allfeed["id"] ?>" class="btn btn-success btn-sm">編集</a>
                                    <a onclick="return confilm('ほんとに消すの？');" href="delete.php?feed_id=<?php echo $allfeed["id"] ?>" class="btn btn-danger btn-sm">削除</a>
                                <?php endif; ?>
                                    <?php include("comment_view.php"); ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($index % 4 == 3 || $index ==count($allfeeds) - 1): ?>
                        <?php echo '</div>' ?>
                    <?php endif; ?>


                    <?php endforeach; ?>
======= -->