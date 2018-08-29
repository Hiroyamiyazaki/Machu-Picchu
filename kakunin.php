<div class="grid-sizer col-sm-12 col-md-6 col-lg-3"></div>
                    <div class="grid-item branding  col-sm-12 col-md-6 col-lg-3">
                        <a href="./assets/img/post_img/<?php echo $feed['img_name'] ?>" title="<?php echo $feed['user_id'] ?>さんの投稿" class="simple-ajax-popup" id="open-popup">
                            <div class="project_box_one">
                                <img src="./assets/img/post_img/<?php echo $feed['img_name'] ?>" alt="pic">
                                <div class="product_info">
                                    <div class="product_info_text">
                                        <div class="product_info_text_inner">
                                            <i class="ion ion-plus"></i>
                                            <h4></h4>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </a>

                    </div>





select ボタンで初期値を元々選択したものにする場合

<?php

    $sql = 'SELECT * FROM `relation` WHERE `id` = ?';


    $data = [];

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);


    $relations = array();
    while (1) {
    // データを１件ずつ取得
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
           break;
        }



    $relations[] = $rec;

  
?>

<select>
  <?php foreach ($relations as $relation): // 選択肢の数だけ繰り返し ?>
    <option <?php echo ($relation === $feed['relation_id']) ? 'selected' : ''; ?>>
      <?php echo $relation; ?>
    </option>
  <?php endforeach; ?>
</select>