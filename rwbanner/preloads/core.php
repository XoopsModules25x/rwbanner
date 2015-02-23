<?php
/**
 * Private Messages
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         pm
 * @since           2.4.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: core.php 11912 2013-08-14 07:47:47Z beckmi $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * rw-banner core preloads
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          mamba
 */
class RwbannerCorePreload extends XoopsPreloadItem
{

    function eventCoreHeaderEnd($args)
    {
        if (RwbannerCorePreload::isActive()) {
            if (file_exists($filename = dirname(dirname(__FILE__)) .'/include/maketags.php')) {
                include $filename;
            }
        }
    }
    function isActive()
    {
        $module_handler =& xoops_getHandler('module');
        $module = $module_handler->getByDirname('rw_banner');
        return ($module && $module->getVar('isactive')) ? true : false;
    }
}