<?php
/**
 * Created by PhpStorm.
 * User: patric
 * Date: 11/18/16
 * Time: 9:52 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <footer>
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-statistics">
                    Elapsed time: <?php echo $this->benchmark->elapsed_time();?>
                    Memory usage: <?php echo $this->benchmark->memory_usage();?>
                </div>
                <div class="footer-copyright">
                    &copy; 2018 by Patric Wellershaus
                </div>
                <div class="footer-legal">
                    <ul>
                        <li><a href="/Legal/cookieUsage">Our Cookie usage</a></li>
                        <li><a href="/Legal/privacyPolicy">Privacy Policy</a></li>
                        <li><a href="/Legal">Impressum</a></li>
                    </ul>
                </div>
                <div class="footer-credit">
                    This site was created with <a href="https://fontawesome.com/license">Font Awesome</a>, <a href="https://github.com/twbs/bootstrap/blob/v4.1.3/LICENSE">Bootstrap</a>, <a href="https://www.codeigniter.com/userguide2/license.html">Code Igniter</a>, <a href="https://jquery.org/license/">jQuery</a> and my hard work.
                </div>
                <div class="footer-credit1">
                    <div>Icons made by <a href="https://www.flaticon.com/authors/good-ware" title="Good Ware">Good Ware</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
