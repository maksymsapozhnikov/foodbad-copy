<?php 
require('includes/application_top.php');

$content = CONTENT_ERROR_403;

require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

require(DIR_WS_INCLUDES . 'application_bottom.php');