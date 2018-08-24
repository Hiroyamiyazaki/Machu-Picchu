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
    function create_feed($dbh, $date, $relation_id, $event_id, $img_name, $feed, $secret_feed, $user_id)
    {
      $sql = 'INSERT INTO `feeds` SET `date`=?, `relation_id`=?, `event_id`=?, `img_name`=?, `feed`=?, `secret_feed`=?, `user_id`=?, `created`=NOW()';
      $data = array($date, $relation_id, $event_id, $img_name, $feed, $secret_feed, $user_id);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
    }