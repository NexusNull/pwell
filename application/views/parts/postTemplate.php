<?php
/**
 * Created by PhpStorm.
 * User: nexus
 * Date: 08/03/17
 * Time: 13:29
 * @var $post Post
 */
if (isset($post)) {
    $postAuthor = $post->getAuthor();
    $postDate = $post->getDateChanged();
    $postText = $post->getText();
    $postTitle = $post->getTitle();
} else {

    $postAuthor = "'+data.author+'";
    $postDate = "'+data.date_changed+'";
    $postText = "'+data.text+'";
    $postTitle = "'+data.title+'";
}

$template = '
<div class="content spacer row post">
    <div>
        <h1 class="post-title clear-fix">' . $postTitle . '</h1>
        <div class="underline"></div>
        <div class="post-meta"><span class="post-author">' . $postAuthor . '</span> ~ <span class="post-date">' . $postDate . '</span>
        </div>
    </div>
    <div class="post-text">
       ' . $postText . '
    </div>
</div>';

if (!isset($post)) {
    $result = "            pwell.postTemplate = function(data) { \n                return '";
    foreach (explode("\n", $template) as $string) {
        $result .= $string;
    }
    $result .= "';\n            }";
    $template = $result;
}
echo "\n" . $template;

