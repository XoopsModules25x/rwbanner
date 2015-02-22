<?php
//  ------------------------------------------------------------------------ //
//                                  RW-Banner                                //
//                    Copyright (c) 2006 Web Applications                    //
//                     <http://www.bcsg.com.br/rwbanner/>                    //
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
// Author: Rodrigo Pereira Lima (Web Applications)                           //
// Site: http://www.bcsg.com.br/rwbanner                                     //
// Project: RW-Banner                                                        //
// Descrição: Sistema de gerenciamento de mídias publicitárias               //
// ------------------------------------------------------------------------- //

function estatisticas_banner($options){
  global $xoopsUser, $xoopsConfig;
  include_once (dirname(dirname(__FILE__)) .'/class/class.banner.php');
  include_once (XOOPS_ROOT_PATH.'/class/pagenav.php');

  if ($xoopsUser){
      $block = array();
      $block['title'] = _MI_RWBANNER_BLOCK2_NAME;

      $uid = $xoopsUser -> getVar( 'uid' );
      
      $order = (isset($_GET['order']))?$_GET['order']:'codigo';
      $seq = (isset($_GET['seq']))?$_GET['seq']:'ASC';
      $start = (isset($_GET['start']))?$_GET['start']:0;
      $limit = (isset($_GET['limit']))?$_GET['limit']:10;

      $ord = ($order != '')?'ORDER BY '.$order.' '.$seq:null;
      
      $sel1 = ($order == 'clicks')?' selected="selected"':'';
      $sel2 = ($order == 'codigo')?' selected="selected"':'';
      $sel3 = ($order == 'data')?' selected="selected"':'';
      $sel4 = ($order == 'exibicoes')?' selected="selected"':'';
      $sel5 = ($seq == 'ASC')?' selected="selected"':'';
      $sel6 = ($seq == 'DESC')?' selected="selected"':'';
      $block['select'] = '

      <select name="order">
        <option value="clicks"'.$sel1.'>'._MB_RWBANNER_CLICKS.'</option>
        <option value="codigo"'.$sel2.'>'._MB_RWBANNER_CODE.'</option>
        <option value="data"'.$sel3.'>'._MB_RWBANNER_CREATION_DATE.'</option>
        <option value="exibicoes"'.$sel4.'>'._MB_RWBANNER_IMPRESSIONS.'</option>
      </select>
      <select name="seq">
        <option value="ASC"'.$sel5.'>ASC</option>
        <option value="DESC"'.$sel6.'>DESC</option>
      </select>';
      
      $qtdes = array('5','10','15','20');
      $block['select1'] = '<select name="limit">';
      for ($i = 0; $i <= count($qtdes)-1; $i++){
        $sel7 = ($limit == $qtdes[$i])?' selected="selected"':'';
        $block['select1'] .= '<option value="'.$qtdes[$i].'"'.$sel7.'>'.$qtdes[$i].'</option>';
      }
      $block['select1'] .= '</select>';
      
      $banner = new RWbanners();
      $arr = $banner->getAllByClient($uid, $ord, null, $limit, $start);
      $total = $banner->getRowNum(null,$uid);
      
      $arr2 = array();
      $arr3 = array();
      for($i = 0; $i <= count($arr)-1; $i++){
        foreach($arr[$i] as $key=>$value){
          $arr2[$key] = $value;
        }
        $arr3[] = $arr2;
      }
      for($i = 0; $i <= count($arr3)-1; $i++){
        $arr3[$i]['exibrest'] = ($arr3[$i]['maxexib'] == 0)?_MB_RWBANNER_EXIBREST:round($arr3[$i]['maxexib']-$arr3[$i]['exibicoes']);
        $arr3[$i]['perc'] = ($arr3[$i]['clicks'] != 0 && $arr3[$i]['exibicoes'] != 0)?round(($arr3[$i]['clicks']/$arr3[$i]['exibicoes'])*100,2):0;
        $arr3[$i]['class'] = ($arr3[$i]['status'] == 0)?'desativ':'ativ';
        $arr3[$i]['link'] = '<a class="'.$arr3[$i]['class'].'" href="javascript:void(0);" onclick="javascript: window.open(\''.dirname(dirname(__FILE__)) .'/admin/exibe.php?id='.$arr3[$i]['codigo'].'\',\'editar\',\'width='.($arr3[$i]['larg']+20).',height='.$arr3[$i]['alt'].',toolbar=no\');">'.$arr3[$i]['codigo'].'</a>';
        $data = $arr3[$i]['data'];
    	$periodo = $arr3[$i]['periodo'];
    	$maxdata = somaData($data,$periodo);
        if ($periodo == 0){
          $arr3[$i]['periodo'] = _MB_RWBANNER_EXIBREST;
        }else{
          $arr3[$i]['periodo'] = converte($maxdata,'BR',0);
        }
        $arr3[$i]['data'] = converte($arr3[$i]['data'],'BR',0);
      }
      $block['rows'] = $arr3;
      
      if (substr($_SERVER['QUERY_STRING'],0,5) != 'start'){
        $arr_qs = explode('&',$_SERVER['QUERY_STRING']);
        $n = (substr($arr_qs[count($arr_qs)-1],0,5) != 'start')?$n = 1:$n = 2;
        $extra_pag = '';
        for ($i = 0; $i <= count($arr_qs)-$n; $i++){
          $extra_pag .= $arr_qs[$i].'&';
        }
        $extra_pag = substr($extra_pag,0,strlen($extra_pag)-1);
      }else{
        $extra_pag = '';
      }
      $pagenav = new XoopsPageNav($total, $limit, $start, 'start', $extra_pag);
      $block['pag'] = $pagenav->renderNav();

      $block['lang_msg1'] = _MB_RWBANNER_MSG1;
      $block['lang_cod'] = _MB_RWBANNER_CODBANNER;
      $block['lang_imp'] = _MB_RWBANNER_IMP;
      $block['lang_rest'] = _MB_RWBANNER_IMPRES;
      $block['lang_clic'] = _MB_RWBANNER_CLIQUES;
      $block['lang_perc'] = _MB_RWBANNER_PORCCLI;
      $block['lang_data'] = _MB_RWBANNER_DATA;
      $block['lang_periodo'] = _MB_RWBANNER_PERIODO;
      $block['lang_button1'] = _MB_RWBANNER_BUTTON1;
      $block['lang_button2'] = _MB_RWBANNER_BUTTON2;
  }else{
    $block['lang_msg2'] = sprintf(_MB_RWBANNER_MSG2,$xoopsConfig['sitename'],XOOPS_URL.'/user.php',XOOPS_URL.'/register.php');
  }
  return $block;
}
