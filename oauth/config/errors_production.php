<?php
//display errorss
ini_set('display_errors', 0);
//log PHP errors
ini_set('log_errors', 1);
//where to log PHP errors?
ini_set('error_log', APP.DS.'logs'.DS.'php'.DS.date("Y-m-d"));
//http://php.net/manual/en/errorfunc.constants.php
