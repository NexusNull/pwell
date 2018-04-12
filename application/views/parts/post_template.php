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
    <div class="post-menu">
        <i class="fa fa-pencil-square-o post-edit button perm_edit_post" style="display:none;" aria-hidden="true"></i>
        <i class="fa fa-check-square-o  post-edit-finished button hidden" aria-hidden="true"></i>
        <i class="fa fa-trash post-delete button perm_delete_post" style="display:none;" aria-hidden="true"></i>
    </div>
    <div>
        <h1 class="post-title clear-fix">' . $postTitle . '</h1>
        <div class="underline"></div>
        <div class="post-meta"><span class="post-author">' . $postAuthor . '</span> ~ <span class="post-date">' . $postDate . '</span>
        </div>
    </div>
        <div class="post-text">' . $postText . '</div>
    </div>';

if (!isset($post)) {
    $result = "            pwell.postTemplate = function(data) { \n                return '";
    foreach (explode("\n", $template) as $string) {
        $result .= $string;
    }
    $result .= "';\n            }";
    $template = $result;
}
$template = str_replace("    ", " ", $template);
$template = str_replace("   ", " ", $template);
$template = str_replace("  ", " ", $template);
$template = str_replace("\n", "", $template);
$template = str_replace("\r", "", $template);


echo "\n" . str_replace("  ", " ", $template);

