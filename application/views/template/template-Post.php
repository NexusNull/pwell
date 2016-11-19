<?php
/**
 * Created by PhpStorm.
 * User: patric
 * Date: 11/19/16
 * Time: 10:30 AM
 */
if (!isset($post)) $post = new Post();
?>
<div class="content spacer row post">
    <img class="post-image" style="width: 100%; height: 100%" src="<?php echo $post->getImageLink(); ?>" alt="Nothing"/>
    <h2 class="post-title spacer"><?php echo $post->getTitle(); ?></h2>
    <div class="post-meta"><span class="post-author"><?php echo $post->getAuthor(); ?></span> ~ <span
            class="post-date"><?php echo $post->getDateWritten(); ?></span></div>
    <p class="post-teaser">
        <?php echo $post->getTeaser(); ?>
    </p>
    <div class="post-text">
        <?php echo $post->getText(); ?>
    </div>
</div>
