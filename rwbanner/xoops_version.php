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

// some bug fixes by luciorota <lucio.rota@gmail.com>

$modversion['name'] = _MI_RWBANNER_NAME;
$modversion['version'] = '1.51';
$modversion['description'] = _MI_RWBANNER_DESC;
$modversion['author'] = "TheRpLima [Rodrigo Pereira Lima] ";
$modversion['credits'] = "BrInfo - Soluções Web na medida certa pra você e sua empresa.";
$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2.0';
$modversion['license_url'] = "www.gnu.org/licenses/gpl-2.0.html";
$modversion['official'] = 0;
$modversion['image'] = "images/slogo.png";
//$modversion['dirname'] = _MI_RWBANNER_DIR_NAME;
$modversion['dirname'] = basename(dirname(__FILE__));

$modversion['dirmoduleadmin'] = '/Frameworks/moduleclasses/moduleadmin';
$modversion['icons16'] = '../../Frameworks/moduleclasses/icons/16';
$modversion['icons32'] = '../../Frameworks/moduleclasses/icons/32';

//about
$modversion['release_date']     = '2013/08/10';
$modversion["module_website_url"] = "www.xoops.org/";
$modversion["module_website_name"] = "XOOPS";
$modversion["module_status"] = "Beta 2";
$modversion["author_website_url"] = "http://www.brinfo.com.br";
$modversion["author_website_name"] = "TheRpLima [Rodrigo Pereira Lima]";
$modversion['min_php']='5.2';
$modversion['min_xoops']="2.5.6";
$modversion['min_admin']='1.1';
$modversion['min_db']= array('mysql'=>'5.0.7', 'mysqli'=>'5.0.7');

//$modversion['onInstall'] = 'install.php';

//Definições da classe about
$modversion['developer_lead'] = "TheRpLima [Rodrigo Pereira Lima]";
$modversion['developer_contributor'] = "";
$modversion['developer_website_url'] = "http://www.brinfo.com.br";
$modversion['developer_website_name'] = "BrInfo - Soluções Web na medida certa pra você e sua empresa.";
$modversion['developer_email'] = "rodrigo@brinfo.com.br";
$modversion['status_version'] = "RC2"; // big fixes by luciorota
$modversion['status'] = "RC2"; // big fixes by luciorota
$modversion['date'] = "08/01/2009"; // big fixes by luciorota
$modversion['warning'] = _MI_RWBANNER_WARNING_RC;
$modversion['demo_site_url'] = "http://rwbanner.brinfo.com.br";
$modversion['demo_site_name'] = "Página de Demonstração do RW-Banner";
$modversion['support_site_url'] = "http://rwbanner.brinfo.com.br/modules/newbb/";
$modversion['support_site_name'] = "Suporte Oficial do RW-BANNER";
$modversion['submit_bug'] = "http://rwbanner.brinfo.com.br/modules/newbb/viewforum.php?forum=3";
$modversion['submit_feature'] = "http://rwbanner.brinfo.com.br/modules/newbb/viewforum.php?forum=2";
$modversion['author_word'] = _MI_RWBANNER_AUTHOR_WORD_DESC;
$modversion['version_history'] = _MI_RWBANNER_HISTORY;

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = _MI_RWBANNER_TABLE1;
$modversion['tables'][1] = _MI_RWBANNER_TABLE2;
$modversion['tables'][2] = _MI_RWBANNER_TABLE3;


// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu']  = "admin/menu.php";
$modversion['system_menu'] = 1;

// Menu.
$modversion['hasMain'] = 1;
global $xoopsModuleConfig, $xoopsUser;
$show = (isset($xoopsModuleConfig['show_cad_form']) && $xoopsModuleConfig['show_cad_form'] == 1)?1:0;
if ($show && $xoopsUser){
  $modversion['sub'][1]['name'] = _MI_RWBANNER_MENU_TITLE3;
  $modversion['sub'][1]['url'] = 'inser.php';
}

//Blocks
$modversion['blocks'][1]['file'] = "banner.php";
$modversion['blocks'][1]['name'] = _MI_RWBANNER_BLOCK1_NAME;
$modversion['blocks'][1]['description'] = _MI_RWBANNER_BLOCK1_NAME_DESC;
$modversion['blocks'][1]['can_clone'] = true ;
$modversion['blocks'][1]['show_func'] = "exibe_banner";
$modversion['blocks'][1]['edit_func'] = "edita_banner";
$modversion['blocks'][1]['options'] = "1|1|1|1";
$modversion['blocks'][1]['template'] = 'block_banner.html';

$modversion['blocks'][2]['file'] = "estatisticas.php";
$modversion['blocks'][2]['name'] = _MI_RWBANNER_BLOCK2_NAME;
$modversion['blocks'][2]['description'] = _MI_RWBANNER_BLOCK2_NAME_DESC;
$modversion['blocks'][2]['show_func'] = "estatisticas_banner";
$modversion['blocks'][2]['template'] = 'block_estatisticas_banner.html';

$modversion['blocks'][3]['file'] = "popadbanner.php";
$modversion['blocks'][3]['name'] = _MI_RWBANNER_BLOCK3_NAME;
$modversion['blocks'][3]['description'] = _MI_RWBANNER_BLOCK3_NAME_DESC;
$modversion['blocks'][3]['can_clone'] = true ;
$modversion['blocks'][3]['show_func'] = "exibe_adbanner";
$modversion['blocks'][3]['edit_func'] = "edita_adbanner";
$modversion['blocks'][3]['options'] = "1|1|1|10|1|F0FFF0|008000|0|1|";
$modversion['blocks'][3]['template'] = 'block_popad_banner.html';

$modversion['blocks'][4]['file'] = "ajaxbanner.php";
$modversion['blocks'][4]['name'] = _MI_RWBANNER_BLOCK4_NAME;
$modversion['blocks'][4]['description'] = _MI_RWBANNER_BLOCK4_NAME_DESC;
$modversion['blocks'][4]['can_clone'] = true ;
$modversion['blocks'][4]['show_func'] = "exibe_ajaxbanner";
$modversion['blocks'][4]['edit_func'] = "edita_ajaxbanner";
$modversion['blocks'][4]['options'] = "1|1|1|30000";
$modversion['blocks'][4]['template'] = 'block_ajax_banner.html';
/*
$modversion['blocks'][5]['file'] = "banner_plugins.php";
$modversion['blocks'][5]['name'] = 'Plugin Banner';
$modversion['blocks'][5]['description'] = 'Exibe banner com conteúdo de outros módulos';
$modversion['blocks'][5]['can_clone'] = true ;
$modversion['blocks'][5]['show_func'] = "exibe_plugin_banner";
$modversion['blocks'][5]['edit_func'] = "edita_plugin_banner";
$modversion['blocks'][5]['options'] = "|1|1";
$modversion['blocks'][5]['template'] = 'block_plugin_banner.html';
*/
$modversion['blocks'][5]['file'] = "dropinbanner.php";
$modversion['blocks'][5]['name'] = _MI_RWBANNER_BLOCK5_NAME;
$modversion['blocks'][5]['description'] = _MI_RWBANNER_BLOCK5_NAME_DESC;
$modversion['blocks'][5]['can_clone'] = true ;
$modversion['blocks'][5]['show_func'] = "exibe_dropbanner";
$modversion['blocks'][5]['edit_func'] = "edita_dropbanner";
$modversion['blocks'][5]['options'] = "1|1|1|1|5|up|200|100|ED710F|";
$modversion['blocks'][5]['template'] = 'block_dropin_banner.html';

$modversion['blocks'][6]['file'] = "lightboxbanner.php";
$modversion['blocks'][6]['name'] = _MI_RWBANNER_BLOCK6_NAME;
$modversion['blocks'][6]['description'] = _MI_RWBANNER_BLOCK6_NAME_DESC;
$modversion['blocks'][6]['can_clone'] = true ;
$modversion['blocks'][6]['show_func'] = "exibe_lightboxbanner";
$modversion['blocks'][6]['edit_func'] = "edita_lightboxbanner";
$modversion['blocks'][6]['options'] = "1|1|5|";
$modversion['blocks'][6]['template'] = 'block_lightbox_banner.html';

//Configs
$modversion['config'][1]['name'] = 'dir_images';
$modversion['config'][1]['title'] = '_MI_RWBANNER_DIRIMAGES';
$modversion['config'][1]['description'] = '_MI_RWBANNER_DIRIMAGES_DESC';
$modversion['config'][1]['formtype'] = 'texbox';
$modversion['config'][1]['valuetype'] = 'text';
$modversion['config'][1]['default'] = XOOPS_ROOT_PATH.'/uploads/'.$modversion['dirname'] ;

$modversion['config'][2]['name'] = 'show_cad_form';
$modversion['config'][2]['title'] = '_MI_RWBANNER_SHOWCADFORM';
$modversion['config'][2]['description'] = '_MI_RWBANNER_SHOWCADFORM_DESC';
$modversion['config'][2]['formtype'] = 'yesno';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = 1;

$modversion['config'][3]['name'] = 'total_reg_index';
$modversion['config'][3]['title'] = '_MI_RWBANNER_NUMREGISTROS';
$modversion['config'][3]['description'] = '_MI_RWBANNER_NUMREGISTROS_DESC';
$modversion['config'][3]['formtype'] = 'texbox';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 10;

$modversion['config'][4]['name'] = 'perm_client';
$modversion['config'][4]['title'] = '_MI_RWBANNER_PERMCLIENT';
$modversion['config'][4]['description'] = '_MI_RWBANNER_PERMCLIENT_DESC';
$modversion['config'][4]['formtype'] = 'yesno';
$modversion['config'][4]['valuetype'] = 'int';
$modversion['config'][4]['default'] = 1;

$modversion['config'][6]['name'] = 'campos_perm';
$modversion['config'][6]['title'] = '_MI_RWBANNER_CAMPOSPERM';
$modversion['config'][6]['description'] = '_MI_RWBANNER_CAMPOSPERM_DESC';
$modversion['config'][6]['formtype'] = 'select_multi';
$modversion['config'][6]['valuetype'] = 'array';
$modversion['config'][6]['options'] = array('Número de exibições' => 'maxexib','Número de cliques' => 'maxclick','Período de Exibição' => 'periodo','Imagem Banner' => 'grafico','Link(Url)' => 'url');
$modversion['config'][6]['default'] = array('url');
