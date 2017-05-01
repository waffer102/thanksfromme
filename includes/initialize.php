<?php
//setup directory structures
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'home'.DS.'thanksfr');
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

//include required files
require_once(LIB_PATH.DS.'sessions.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'functions.php');
require_once(LIB_PATH.DS.'user.php');
require_once(LIB_PATH.DS.'role.php');
require_once(LIB_PATH.DS.'role_perm.php');
require_once(LIB_PATH.DS.'business_unit.php');
require_once(LIB_PATH.DS.'department.php');
require_once(LIB_PATH.DS.'category.php');
require_once(LIB_PATH.DS.'category_perm.php');
require_once(LIB_PATH.DS.'appreciation.php');
require_once(LIB_PATH.DS.'upload.php');
require_once(LIB_PATH.DS.'user_configuration.php');
require_once(LIB_PATH.DS.'company_configuration.php');