<?php
/**
 * Created by PhpStorm.
 * User: patric
 * Date: 11/19/16
 * Time: 10:29 AM
 */
if (!isset($post)) $post = new Post();
?>
<div class="content row post-thumbnail row-no-padding">
    <div class="col-xs-3">
        <img class="post-image" src="<?php echo $post->getImageLink(); ?>"
             style="float left; width: 150px; height: auto" alt="Nothing"/>
    </div>
    <div class="col-xs-9">
        <h3 class="post-title"><?php echo $post->getTitle(); ?></h3>
        <div class="post-meta"><span class="post-author"><?php echo $post->getAuthor(); ?></span> ~ <span
                class="post-date"><?php echo $post->getDateWritten(); ?></span></div>
        <p class="post-teaser">
            <?php echo $post->getTeaser(); ?>
        </p>
    </div>
</div>
