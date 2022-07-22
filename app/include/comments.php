<?php
include SITE_ROOT . "/app/controllers/commentaries.php";
?>
<?php
if(isset($_GET["post"])){

    $post_idd = $_GET["post"];
}

$comments = selectAll('comments', ['page'=>$post_idd]);
?>
<div class="cpl-md-12 col-12 comments">
    <h3>Leave a comment</h3>
    <form action="<?=BASE_URL . "single.php?post=$post_idd"?>" method="post">
        <input type="hidden" name="post_idd" value="<?=$post_idd; ?>">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input name="email" type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Write your review</label>
            <textarea name="comment" class="form-control" id="exampleFormControlTextarea1" rows="4"></textarea>
        </div>
        <div class="col-12">
            <button type="submit" name="goComment" class="btn btn-primary">Send</button>
        </div>
    </form>
        <div class="row all-comments">
            <h3 class="col-12">Comments on the entry</h3>
            <?php foreach ($comments as $comment): ?>
                <div class="one-comment col-12">
                    <span><i class="far fa-envelope"></i><?=$comment['email']  ?></span>
                    <span><i class="far fa-calendar-check"></i><?=$comment['created_date']  ?></span>
                    <div class="col-12 text">
                        <?=$comment['comment']  ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
</div>
