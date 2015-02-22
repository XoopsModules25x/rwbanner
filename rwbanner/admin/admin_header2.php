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

$path = dirname(dirname(dirname(dirname(__FILE__))));
include_once $path . '/mainfile.php';
include_once $path . '/include/cp_header.php';
include_once $path ."/kernel/module.php";
include_once $path ."/class/xoopstree.php";
include_once $path ."/class/xoopslists.php";
include_once $path ."/class/xoopsformloader.php";
include_once $path .'/class/pagenav.php';

if (is_object($xoopsUser)){
    $dirname         = basename(dirname(dirname(__FILE__)));
    $module_handler  = xoops_gethandler('module');
    $module          = $module_handler->getByDirname($dirname);
  if (!$xoopsUser->isAdmin($module->mid())){
    redirect_header(XOOPS_URL."/",1,_MD_RWBANNER_NOPERM);
	exit();
  }
}else{
  redirect_header(XOOPS_URL."/",1,_MD_RWBANNER_NOPERM);
  exit();
}

include_once XOOPS_ROOT_PATH."/modules/".$module->dirname()."/include/functions.php";

if ( file_exists("../language/".$xoopsConfig['language']."/modinfo.php") ) {
	include("../language/".$xoopsConfig['language']."/modinfo.php");
} else {
	include("../language/english/modinfo.php");
}

$myts =& MyTextSanitizer::getInstance();
