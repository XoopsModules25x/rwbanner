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

function exibe_dropbanner($options){
  global $xoopsConfig;
  include_once (dirname(dirname(__FILE__)) .'/class/class.categoria.php');
  include_once (dirname(dirname(__FILE__)) .'/class/class.banner.php');
  include_once (dirname(dirname(__FILE__)) .'/language/'.$xoopsConfig['language']."/modinfo.php");
//    include_once (dirname(dirname(__FILE__)) .'/admin/admin_header.php');

// $path = dirname(dirname(dirname(dirname(__FILE__))));
//
//include_once $path . '/header.php';

//require(XOOPS_ROOT_PATH.'/header.php');

global $xoopsTpl;
$dirname        = basename(dirname(dirname(__FILE__)));
$xoopsTpl->assign('module_dir', $dirname );

  $myts =& MyTextSanitizer::getInstance();

  $block = array();

  //recebendo parâmetros de configuração
  $block['categ'] = $options[0];
  $block['qtde']  = $options[1];
  $block['cols']  = $options[2];
  $block['type']  = $options[3];
  $block['freq']  = $options[4];
  $block['direction']  = $options[5];
  $block['left']  = $options[6];
  $block['top'] = $options[7];
  $block['bgcolor'] = $options[8];
  $block['conteudo'] = $options[9];
  $block['title'] = _MI_RWBANNER_BLOCK5_NAME;
  $block['lang_close'] = _MB_RWBANNER_TEXT4;
  
  $categ = new Categoria(null,$options[0]);
  $block['width'] = ($block['qtde'] > 1 && $block['cols'] > 1)?(($categ->getLarg()*$block['qtde'])+40):($categ->getLarg()+40);
  $block['height'] = ($block['qtde'] > 1 && $block['cols'] == 1)?(($categ->getAlt()*$block['qtde'])+40):($categ->getAlt()+40);
  $block['larg'] = $categ->getLarg();
  $block['alt'] = $categ->getAlt();

  $banner = new RWbanners();
  $arr = $banner->getBanners(false, 'ORDER BY RAND()', $options[0], $options[1]);

  $arr2 = array();
  $arr3 = array();
  for($i = 0; $i <= count($arr)-1; $i++){
    foreach($arr[$i] as $key=>$value){
      $arr2[$key] = $value;
    }
    $arr3[] = $arr2;
  }
  for($i = 0; $i <= count($arr3)-1; $i++){
    if (stristr($arr3[$i]['grafico'], '.swf')) {
      $arr3[$i]['swf'] = 1;
      $arq = explode('/',$arr3[$i]['grafico']);
      $grafico1 = _RWBANNER_DIRIMAGES.'/'.$arq[count($arq)-1];
      include_once(dirname(dirname(__FILE__)) .'/class/FlashHeader.php');
      $f = new FlashHeader($grafico1);
      $result = $f->getimagesize();
      $arr3[$i]['fps'] = ($result['frameRate']);
    }
  }
  $block['banners'] = $arr3;
  
  return $block;
}

function edita_dropbanner($options){
  global $xoopsDB;

  $query = "SELECT cod,titulo FROM ".$xoopsDB->prefix("rw_categorias");
  $consulta = $xoopsDB->queryF($query);
  $categ = _MB_RWBANNER_OPTION1."&nbsp;<select options[0] name=\"options[0]\" onchange='javascript:options0.value = this.value;'>";
  while(list($cod,$titulo) = $xoopsDB->fetchRow($consulta)){
  if ($options[0] == $cod)
    $sel = 'selected';
  else
    $sel = '';
  $categ .= '<option value="'.$cod.'" '.$sel.'>'.$titulo.'</option>';
  }
  $categ .= '</select>';
  $form = $categ;
  //Quantidade de banners à exibir no bloco
  $qtde = _MB_RWBANNER_OPTION2."&nbsp;<input type='text' name='options[1]' value='".$options[1]."' onchange='javascript:options1.value = this.value;' />";
  $form .= "<br />".$qtde;
  //Quantidade de colunas em que os banners serão exibidos
  $qtde = _MB_RWBANNER_OPTION3."&nbsp;<input type='text' name='options[2]' value='".$options[2]."' onchange='javascript:options2.value = this.value;' />";
  $form .= "<br />".$qtde;
  //Tipo de exibição do box.
  $arr = array("1"=>_MB_RWBANNER_OPTION16_1,"2"=>_MB_RWBANNER_OPTION16_2,"3"=>_MB_RWBANNER_OPTION16_3);
  $qtde = _MB_RWBANNER_OPTION16."&nbsp;<select options[3] name=\"options[3]\">";
  foreach($arr as $key=>$value){
    $sel = ($key == $options[3])?'selected':'';
    $qtde .= '<option value="'.$key.'" '.$sel.'>'.$value.'</option>';
  }
  $qtde .= '</select>';
  $form .= "<br />".$qtde;
  //Taxa de exibição do box (1/taxa)
  $teste = _MB_RWBANNER_OPTION17."&nbsp;<input type='text' id='freq' name='options[4]' value='".$options[4]."' />";
  $form .= "<br />".$teste;
  //Direção do "aparecimento" do box
  $arr = array("up"=>_MB_RWBANNER_OPTION18_1,"down"=>_MB_RWBANNER_OPTION18_2);
  $qtde = _MB_RWBANNER_OPTION18."&nbsp;<select options[5] name=\"options[5]\" onchange='javascript:habilita(this.value);'>";
  foreach($arr as $key=>$value){
    $sel = ($key == $options[5])?'selected':'';
    $qtde .= '<option value="'.$key.'" '.$sel.'>'.$value.'</option>';
  }
  $qtde .= '</select>';
  $form .= "<br />".$qtde;
  //Posição esquerda
  $qtde = _MB_RWBANNER_OPTION19."&nbsp;<input type='text' name='options[6]' value='".$options[6]."' onchange='javascript:options6.value = this.value;' />";
  $form .= "<br />".$qtde;
  //Posição top
  $qtde = _MB_RWBANNER_OPTION20."&nbsp;<input type='text' name='options[7]' value='".$options[7]."' onchange='javascript:options7.value = this.value;' />";
  $form .= "<br />".$qtde;
  //Background
  $qtde = _MB_RWBANNER_OPTION21."&nbsp;<input type='text' name='options[8]' value='".$options[8]."' onchange='javascript:options7.value = this.value;' />";
  $form .= "<br />".$qtde;
  $form .= '<br /><br />'._MB_RWBANNER_OPTION10;

  include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

  $cont = new XoopsFormDhtmlTextArea('','options[9]',$options[9],10);

  $form .= '<br />'.$cont->render().'<br />'._MB_RWBANNER_OPTION11;

  return $form;
}
