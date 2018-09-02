<?php



  // サインインユーザー取得 
    function get_user($dbh, $user_id)
    {
      $sql = 'SELECT * FROM  `users` WHERE `id` = ?';
      $data = [$user_id];
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      return $stmt->fetch(PDO::FETCH_ASSOC);
    }


//投稿処理
    function create_feed($dbh, $date, $relation_id, $event_id, $submit_file_name, $feed, $secret_feed, $user_id)
    { 
      $sql = 'INSERT INTO `feeds` SET `date`=?, `relation_id`=?, `event_id`=?, `img_name`=?, `feed`=?, `secret_feed`=?, `user_id`=?, `created`=NOW()';
      $data = array($date, $relation_id, $event_id, $submit_file_name, $feed, $secret_feed, $user_id);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
    }


//いいねの件数
    function count_like($dbh, $feed_id)
    {
      $like_sql = "SELECT COUNT(*)AS `like_cnt` FROM `likes` WHERE `feed_id` =?";

      $like_data = [$feed_id];

      $like_stmt = $dbh->prepare($like_sql);
      $like_stmt->execute($like_data);

      $like = $like_stmt->fetch(PDO::FETCH_ASSOC);

      return $like["like_cnt"];
    }


//いいね済みかどうかの確認
    function is_liked($dbh, $user_id, $feed_id)
    {
      $like_flg_sql = "SELECT * FROM `likes` WHERE `user_id` = ? AND `feed_id` = ?";

      $like_flg_data = [$user_id, $feed_id];

      $like_flg_stmt = $dbh->prepare($like_flg_sql);
      $like_flg_stmt->execute($like_flg_data);

      $is_liked = $like_flg_stmt->fetch(PDO::FETCH_ASSOC);

      return $is_liked ? true : false;
    }


//コメント取得
    function get_comment($dbh, $feed_id)
    {
      $sql = "SELECT `c`.*, `u`.`user_id` FROM `comments` AS `c` JOIN `users` AS `u` ON `c`.`user_id` = `u`.id WHERE `feed_id` = ?";

      $data = [$feed_id];

      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $comments = [];

      while(true) {
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($comment == false) break;

        $comments[] = $comment;
      }

      return $comments;
    }


//コメント数取得
    function count_comment($dbh, $feed_id)
    {
      $sql = "SELECT COUNT(*) AS `comment_cnt` FROM `comments` WHERE `feed_id` = ?";

      $data = [$feed_id];

      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $comment = $stmt->fetch(PDO::FETCH_ASSOC);

      return $comment["comment_cnt"];
    }





//アカウント登録

    function what_age($dbh)
    {
      $sql = "SELECT * FROM `ages`";
      $stmt = $dbh->prepare($sql);
      $stmt->execute();

      $ages = array();

      while(1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rec==false){
          break;

        }

      $ages[] = $rec;
      }

       return $ages;

    }


        function what_job($dbh)
    {
      $sql = "SELECT * FROM `jobs`";
      $stmt = $dbh->prepare($sql);
      $stmt->execute();

      $jobs = array();

      while(1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rec==false){
          break;

        }

      $jobs[] = $rec;
      }

       return $jobs;

    }




// 検索ボタン

    //相手欄
    function who_relation($dbh)
    {
      $sql = "SELECT * FROM `relations`";
      $stmt = $dbh->prepare($sql);
      $stmt->execute();

      $relations = array();

      while(1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rec==false){
          break;

        }

      $relations[] = $rec;

      }

      return $relations;

    }
    

    //イベント
    function what_event($dbh)
    {
      $sql = "SELECT * FROM `events`";
      $stmt = $dbh->prepare($sql);
      $stmt->execute();

      $events = array();

      while(1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rec==false){
          break;

        }

        $events[] = $rec;
      }

        return $events;

    }