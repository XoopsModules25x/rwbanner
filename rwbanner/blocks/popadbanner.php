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

function exibe_adbanner($options){
  include_once (dirname(dirname(__FILE__)) .'/class/class.categoria.php');
  include_once (dirname(dirname(__FILE__)) .'/class/class.banner.php');

  $myts =& MyTextSanitizer::getInstance();

  $block = array();

  //recebendo parâmetros de configuração
  $block['categ'] = $options[0];
  $block['qtde']  = $options[1];
  $block['cols']  = $options[2];
  $block['time']  = $options[3];
  $block['vezes']  = $options[4];
  $block['bgcolor']  = $options[5];
  $block['border']  = $options[6];
  $block['espaco'] = $options[7];
  $block['mostrar'] = $options[8];
  $block['conteudo'] = $options[9];
  $block['title'] = _MB_RWBANNER_BLOCK3_NAME;
  $block['lang_mb_text1'] = _MB_RWBANNER_TEXT1;
  
  $categ = new Categoria(null,$options[0]);
  $block['larg'] = ($block['qtde'] > 1 && $block['cols'] > 1)?(($categ->getLarg()*$block['qtde'])+20):($categ->getLarg());
  $block['alt'] = ($block['qtde'] > 1 && $block['cols'] == 1)?(($categ->getAlt()*$block['qtde'])+20):($categ->getAlt());

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

function edita_adbanner($options){
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
  $qtde = _MB_RWBANNER_OPTION2."&nbsp;<input type='text' name='options[]' value='".$options[1]."' onchange='javascript:options1.value = this.value;' />";
  $form .= "<br />".$qtde;
  //Quantidade de colunas em que os banners serão exibidos
  $qtde = _MB_RWBANNER_OPTION3."&nbsp;<input type='text' name='options[]' value='".$options[2]."' onchange='javascript:options2.value = this.value;' />";
  $form .= "<br />".$qtde;
  //Tempo de Exibição da Janela
  $qtde = _MB_RWBANNER_OPTION14."&nbsp;<input type='text' name='options[]' value='".$options[3]."' onchange='javascript:options3.value = this.value;' />";
  $form .= "<br />".$qtde;
  //Será exibido novamente em quantos reloads?
  $qtde = _MB_RWBANNER_OPTION5."&nbsp;<input type='text' name='options[]' value='".$options[4]."' onchange='javascript:options4.value = this.value;' />";
  $form .= "<br />".$qtde;
  //Cor de fundo
  $qtde = _MB_RWBANNER_OPTION6."&nbsp;<input type='text' name='options[]' value='".$options[5]."' onchange='javascript:options5.value = this.value;' />";
  $form .= "<br />".$qtde;
  //Cor da Borda
  $qtde = _MB_RWBANNER_OPTION7."&nbsp;<input type='text' name='options[]' value='".$options[6]."' onchange='javascript:options6.value = this.value;' />";
  $form .= "<br />".$qtde;
  //Espaço entre os banners
  $qtde = _MB_RWBANNER_OPTION8."&nbsp;<input type='text' name='options[]' value='".$options[7]."' onchange='javascript:options7.value = this.value;' />";
  $form .= "<br />".$qtde;
  $mostrar = "<br />"._MB_RWBANNER_OPTION9."&nbsp;<select options[8] name=\"options[8]\" onchange='javascript:options8.value = this.value;'>";
  if ($options[8] == 1)
    $mostrar .= '<option value="1" selected>'._MB_RWBANNER_TEXT2.'</option>';
  else
    $mostrar .= '<option value="1">'._MB_RWBANNER_TEXT2.'</option>';
  if ($options[8] == 0)
    $mostrar .= '<option value="0" selected>'._MB_RWBANNER_TEXT3.'</option>';
  else
    $mostrar .= '<option value="0">'._MB_RWBANNER_TEXT3.'</option>';
  $mostrar .= '</select>';
  $form .= $mostrar.'<br /><br />'._MB_RWBANNER_OPTION10;

  include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

  $cont = new XoopsFormDhtmlTextArea('','options[]',$options[9],10);

  $form .= '<br />'.$cont->render().'<br />'._MB_RWBANNER_OPTION11;

  return $form;
}
