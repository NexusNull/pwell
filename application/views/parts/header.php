<?php
/**
 * Created by PhpStorm.
 * User: patric
 * Date: 6/26/16
 * Time: 8:27 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head><?php
    foreach ($style_src as $src) {
        echo "    <link rel=\"stylesheet\" href=\"$src\">\n";
    }
    foreach ($js_src as $src) {
        echo "    <script type=\"text/javascript\" src=\"$src\"></script>\n";
    }
    foreach ($meta as $html) {
        echo "    $html\n";
    }
    echo "    <script type='application/javascript'>";

    echo $custom_js;
    $this->load->view('parts/post_template');
    echo "\n    </script>\n";
    unset($src);
    unset($html);
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patric Wellershaus</title>
</head>
<body>

