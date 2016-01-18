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

include_once("admin_header.php");
include_once ("../class/class.banner.php");

if ($_GET['id'] == '') $id = $_POST['id']; else $id = $_GET['id'];

$banner = new RWbanners(null,$id);

if ($banner->getUsarhtml() == 1){
  echo $banner->getHtmlcode();
}else{
  if (stristr($banner->getGrafico(), '.swf')) {
    echo
    '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="'.$banner->getLargura().'" height="'.$banner->getAltura().'">'
    .'<param name=movie value="'.$banner->getGrafico().'">'
    .'<param name=quality value=high>'
    .'<embed src="'.$banner->getGrafico().'" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"; type="application/x-shockwave-flash" width="'.$banner->getLargura().'" height="'.$banner->getAltura().'">'
    .'</embed>'
    .'</object>';
  }else{
    echo '<div align="center" style="margin:0px; padding:0px"><img src="'.$banner->getGrafico().'" width="'.$banner->getLargura().'" height="'.$banner->getAltura().'" border="0"></div><br><br>';
  }
}
