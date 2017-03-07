<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: nexus
 * Date: 07/03/17
 * Time: 17:16
 * Setting the variables the are configurable from the php side.
 */

require_once "../application/config/reCaptcha.php";
?>

if (typeof pwell == "undefined")
pwell = {};
pwell.reCaptchaSiteKey = "<?php echo RECAPTCHA_SITEKEY; ?>";

