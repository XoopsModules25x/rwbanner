<?php
/**
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright    The XOOPS Project (http://www.xoops.org)
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU Public License}
 * @author       XOOPS Development Team
 * @version      $Id $
 **/

$path = dirname(dirname(dirname(dirname(__FILE__))));
include_once $path . '/mainfile.php';
include_once $path . '/header.php';
include_once $path . '/include/cp_functions.php';
require_once $path . '/include/cp_header.php';

include_once $path . "/kernel/module.php";
include_once $path . "/class/xoopstree.php";
include_once $path . "/class/xoopslists.php";
include_once $path . "/class/xoopsformloader.php";
include_once $path . '/class/pagenav.php';

$dirname        = basename(dirname(dirname(__FILE__)));
$module_handler = xoops_gethandler('module');
$module         = $module_handler->getByDirname($dirname);

if (is_object($xoopsUser)) {
    $xoopsModule = XoopsModule::getByDirname($dirname);
    if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL . "/", 1, _MD_RWBANNER_NOPERM);
        exit();
    }
} else {
    redirect_header(XOOPS_URL . "/", 1, _MD_RWBANNER_NOPERM);
    exit();
}

global $xoopsModule;

//$thisModuleDir = $GLOBALS['xoopsModule']->getVar('dirname');

//if functions.php file exist
require_once dirname(dirname(__FILE__)) . '/include/functions.php';
$myts =& MyTextSanitizer::getInstance();

//$xoopsTpl->assign('module_dir', $module->getVar('dirname'));

// Load language files
xoops_loadLanguage('admin', $dirname);
xoops_loadLanguage('modinfo', $dirname);
xoops_loadLanguage('main', $dirname);

$pathIcon16      = '../' . $xoopsModule->getInfo('icons16');
$pathIcon32      = '../' . $xoopsModule->getInfo('icons32');
$pathModuleAdmin = $xoopsModule->getInfo('dirmoduleadmin');

if (file_exists($GLOBALS['xoops']->path($pathModuleAdmin . '/moduleadmin.php'))) {
    include_once $GLOBALS['xoops']->path($pathModuleAdmin . '/moduleadmin.php');
} else {
    redirect_header("../../../admin.php", 5, _AM_MODULEADMIN_MISSING, false);
}
