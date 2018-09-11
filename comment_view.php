

     <div class="collapse" id="collapseComment<?php echo $allfeed["id"] ?>">
        <form method="post" class="form-inline" action="comment.php" role="comment">
            <div class="form-group">
                <p><?php echo $signin_user['user_id'] ?></p>
            </div>
            <div class="form-group">
                <input type="text" name="write_comment" class="form-control" style="width:400px;border-radius: 100px!important; -webkit-appearance:none;" placeholder="コメントを書く">
            </div>
            <input type="hidden" name="feed_id" value="<?php echo $allfeed["id"] ?>">
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-primary">投稿する</button>
            </div>
        </form>
     </div>
