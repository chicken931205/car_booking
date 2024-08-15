<?php

/******************************************************************************/
/******************************************************************************/

require_once('define.php');

/******************************************************************************/

require_once(PLUGIN_CPBS_CLASS_PATH.'CPBS.File.class.php');
require_once(PLUGIN_CPBS_CLASS_PATH.'CPBS.Include.class.php');
require_once(PLUGIN_CPBS_CLASS_PATH.'CPBS.Widget.class.php');

CPBSInclude::includeClass(PLUGIN_CPBS_LIBRARY_PATH.'/stripe/init.php',array('Stripe\Stripe'));
CPBSInclude::includeFileFromDir(PLUGIN_CPBS_CLASS_PATH);

/******************************************************************************/
/******************************************************************************/