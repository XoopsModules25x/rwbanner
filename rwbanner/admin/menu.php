<?php
//  ------------------------------------------------------------------------ //
//                                  RW-Banner                                //
//                    Copyright (c) 2006 BrInfo                              //
//                     <http://www.brinfo.com.br>                            //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
// Author: Rodrigo Pereira Lima (BrInfo - Soluções Web)                      //
// Site: http://www.brinfo.com.br                                            //
// Project: RW-Banner                                                        //
// Descrição: Sistema de gerenciamento de mídias publicitárias               //
// ------------------------------------------------------------------------- //

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

$dirname = basename(dirname(dirname(__FILE__)));
$module_handler = xoops_gethandler('module');
$module = $module_handler->getByDirname($dirname);
$pathIcon32 = $module->getInfo('icons32');

xoops_loadLanguage('admin', $dirname);

$adminmenu = array();

$i = 1;
$adminmenu[$i]["title"] = _MI_RWBANNER_MENU_TITLE0;
$adminmenu[$i]["link"] = 'admin/index.php';
$adminmenu[$i]["icon"] = $pathIcon32.'/home.png';

$i++;
$adminmenu[$i]["title"] = _MI_RWBANNER_MENU_TITLE1;
$adminmenu[$i]["link"] = 'admin/main.php';
$adminmenu[$i]["icon"] = $pathIcon32.'/manage.png';

//$i++;
//$adminmenu[$i]["title"] = _MI_RWBANNER_MENU_TITLE2;
//$adminmenu[$i]["link"] = "admin/myblocksadmin.php";
//$adminmenu[$i]["icon"] = $pathIcon32.'/block.png';

$i++;
$adminmenu[$i]["title"] = _MI_RWBANNER_MENU_TITLE3;
$adminmenu[$i]["link"] = "admin/inser.php";
$adminmenu[$i]["icon"] = '././images/icon/32/page_add.png';

$i++;
$adminmenu[$i]["title"] = _MI_RWBANNER_MENU_TITLE4;
$adminmenu[$i]["link"] = "admin/insercateg.php";
$adminmenu[$i]["icon"] = $pathIcon32.'/categoryadd.png';

$i++;
$adminmenu[$i]["title"] = _MI_RWBANNER_MENU_TITLE8;
$adminmenu[$i]["link"] = "admin/insertag.php";
$adminmenu[$i]["icon"] = '././images/icon/32/tag_blue_add.png';

$i++;
$adminmenu[$i]["title"] = _AM_RWBANNER_IMPORT;
$adminmenu[$i]["link"] = "admin/import.php";
$adminmenu[$i]["icon"] = $pathIcon32.'/download.png';

//$i++;
//$adminmenu[$i]["title"] = _AM_RWBANNER_PERMISSIONS;
//$adminmenu[$i]["link"] = "admin/permissions.php";
//$adminmenu[$i]["icon"] = $pathIcon32.'/permissions.png';

//$i++;
//$adminmenu[$i]["title"] = _MI_RWBANNER_MENU_TITLE6;
//$adminmenu[$i]["link"] = "admin/about2.php";
//$adminmenu[$i]["icon"] = $pathIcon32.'/about.png';

$i++;
$adminmenu[$i]["title"] = _MI_RWBANNER_MENU_TITLE6;
$adminmenu[$i]["link"] = 'admin/about.php';
$adminmenu[$i]["icon"] = $pathIcon32.'/about.png';
