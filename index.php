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

$path = dirname(dirname(__DIR__));
include_once $path . '/mainfile.php';
include_once 'class/class.banner.php';
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

if (file_exists(__DIR__ . '/language/' . $xoopsConfig['language'] . '/admin.php')) {
    include __DIR__ . '/language/' . $xoopsConfig['language'] . '/admin.php';
} else {
    include __DIR__ . '/language/english/admin.php';
}

/*
$cod = (isset($_GET['cod']))?$_GET['cod']:((isset($_POST['cod']))?$_POST['cod']:'');
$url = (isset($_GET['url']))?$_GET['url']:((isset($_POST['url']))?$_POST['url']:'');
*/
$uid = $xoopsUser ? $xoopsUser->getVar('uid') : 0;
$op  = isset($_GET['op']) ? $_GET['op'] : (isset($_POST['op']) ? $_POST['op'] : 'lista');
switch ($op) {
    case 'lista':
        $order = isset($_GET['order']) ? $_GET['order'] : 'codigo';
        $seq   = isset($_GET['seq']) ? $_GET['seq'] : 'ASC';
        $start = isset($_GET['start']) ? $_GET['start'] : 0;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
        include_once(XOOPS_ROOT_PATH . '/header.php');
        if ($uid != 0) {
            echo '<p style="text-align:justify;">' . sprintf(_MD_RWBANNER_MSG_INDEX_OLAUSER, $xoopsUser->getVar('uname'), $xoopsConfig['sitename']) . '</p>';
            lista_banners($uid, $order, $seq, $limit, $start);
        } else {
            echo '<p style="text-align:justify;">' . sprintf(_MD_RWBANNER_MSG_INDEX_NOUSER, $xoopsConfig['sitename'], XOOPS_URL . '/user.php', XOOPS_URL . '/register.php') . '</p>';
        }
        include_once(XOOPS_ROOT_PATH . '/footer.php');
        break;
    case 'sendemail':
        $id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : '');
        if (EmailStats($id)) {
            redirect_header('index.php', 3, _MD_RWBANNER_MSG_SUCESS_EMAILSTATS);
        } else {
            redirect_header('index.php', 3, _MD_RWBANNER_MSG_FAIL_EMAILSTATS);
        }
        break;
}

/**
 * @param        $uid
 * @param null   $order
 * @param string $seq
 * @param int    $limit
 * @param int    $start
 */
function lista_banners($uid, $order = null, $seq = '', $limit = 10, $start = 0)
{
    global $xoopsModule, $xoopsModuleConfig;
    $pathIcon16 =& $xoopsModule->getInfo('icons16');

    $banner = new RWbanners();
    $total  = $banner->getRowNum(null, $uid);

    if ($total > 0) {
        echo ($xoopsModuleConfig['show_cad_form'] == 1) ? '<p style="text-align:justify;">' . _MD_RWBANNER_MSG_INDEX_CADBANNER . '</p><p style="text-align:justify;">' . _MD_RWBANNER_MSG_NEWBANNER . '</p>' : '<p style="text-align:justify;">' . _MD_RWBANNER_MSG_INDEX_NOBANNER1 . '</p>';
        $ord = ($order != '') ? 'ORDER BY ' . $order . ' ' . $seq : null;

        $sel1 = ($order === 'clicks') ? ' selected="selected"' : '';
        $sel2 = ($order === 'codigo') ? ' selected="selected"' : '';
        $sel3 = ($order === 'data') ? ' selected="selected"' : '';
        $sel4 = ($order === 'exibicoes') ? ' selected="selected"' : '';
        $sel5 = ($seq === 'ASC') ? ' selected="selected"' : '';
        $sel6 = ($seq === 'DESC') ? ' selected="selected"' : '';

        echo '<div align="center" style="width:100%; display:inline; margin:0; padding:0;" nowrap>
    <p>
    <form method="GET">
    <select name="order">
      <option value="clicks"' . $sel1 . '>' . _MD_RWBANNER_SORT_CLICKS . '</option>
      <option value="codigo"' . $sel2 . '>' . _MD_RWBANNER_SORT_ID . '</option>
      <option value="data"' . $sel3 . '>' . _MD_RWBANNER_SORT_DATE . '</option>
      <option value="exibicoes"' . $sel4 . '>' . _MD_RWBANNER_SORT_IMPRESSIONS . '</option>
    </select>
    <select name="seq">
      <option value="ASC"' . $sel5 . '>ASC</option>
      <option value="DESC"' . $sel6 . '>DESC</option>
    </select> <input type="submit" value="' . _MD_RWBANNER_BUTTON1 . '">';
        echo '<input type="hidden" name="limit" value="' . $limit . '">';
        echo '<input type="hidden" name="start" value="' . $start . '">';
        echo '</form>';

        $qtdes = array('5', '10', '15', '20');
        echo '</p><p><form method="GET"><select name="limit">';
        for ($i = 0; $i <= count($qtdes) - 1; ++$i) {
            $sel7 = ($limit == $qtdes[$i]) ? ' selected="selected"' : '';
            echo '<option value="' . $qtdes[$i] . '"' . $sel7 . '>' . $qtdes[$i] . '</option>';
        }
        echo '</select> <input type="submit" value="' . _MD_RWBANNER_BUTTON2 . '">';
        echo '<input type="hidden" name="order" value="' . $order . '">';
        echo '<input type="hidden" name="seq" value="' . $seq . '">';
        echo '<input type="hidden" name="start" value="' . $start . '">';
        echo '</form></p>
    </div><br />';

        $lista_banners = $banner->getAllByClient($uid, $ord, null, $limit, $start);

        $extra_sel = ($start != 0) ? '&start=' . $start : '';
        $seq       = ($seq === 'ASC') ? 'DESC' : 'ASC';

        echo '
    <table style="font-size:10px;" width="100%" class="outer">
      <tr class="head">
        <td colspan="11" align="center"><h2 style="margin:2px;">' . _MD_RWBANNER_TITLE1 . '</h2></td>
      </tr>
      <tr class="head">
        <td align="center" valign="middle" style="padding:5px;">' . _AM_RWBANNER_TITLE2 . '</td>
        <td align="center" valign="middle" style="padding:5px;">' . _AM_RWBANNER_TITLE4 . '</td>
        <td align="center" valign="middle" style="padding:5px;">' . _AM_RWBANNER_TITLE5 . '</td>
        <td align="center" valign="middle" style="padding:5px;">' . _AM_RWBANNER_TITLE6 . '</td>
        <td align="center" valign="middle" style="padding:5px;">' . _AM_RWBANNER_TITLE7 . '</td>
        <td align="center" valign="middle" style="padding:5px;">' . _AM_RWBANNER_TITLE39 . '</td>
        <td align="center" valign="middle" style="padding:5px;">' . _AM_RWBANNER_TITLE8 . '</td>
        <td align="center" valign="middle" style="padding:5px;">' . _AM_RWBANNER_TITLE9 . '</td>
        <td align="center" valign="middle" style="padding:5px;">' . _AM_RWBANNER_TITLE99 . '</td>
        <td align="center" valign="middle" style="padding:5px;">' . _AM_RWBANNER_TITLE10 . '</td>
        <td align="center" valign="middle" style="padding:5px;">' . _AM_RWBANNER_TITLE11 . '</td>
      </tr>';
        $class = 'even';
        for ($i = 0; $i <= count($lista_banners) - 1; ++$i) {
            if ($lista_banners[$i]->getStatus() != 0) {
                $status = '<img src=' . $pathIcon16 . '/green.gif' . ' width="16" height="16" border="0" alt="' . _AM_RWBANNER_BANNER_STATUS1 . '" title="' . _AM_RWBANNER_BANNER_STATUS1 . '">';
                $estilo = '';
            } else {
                $status = '<img src=' . $pathIcon16 . '/red.gif' . ' width="16" height="16" border="0" alt="' . _AM_RWBANNER_BANNER_STATUS2 . '" title="' . _AM_RWBANNER_BANNER_STATUS2 . '">';
                $estilo = 'style="color:red;"';
            }
            $class = ($class === 'even') ? 'odd' : 'even';

            if ($lista_banners[$i]->getMaxexib() == 0) {
                $exibrest = _AM_RWBANNER_BANNER_EXIBREST;
            } else {
                $exibrest = round($lista_banners[$i]->getMaxexib() - $lista_banners[$i]->getExibicoes());
            }
            if ($lista_banners[$i]->getMaxclick() == 0) {
                $exibrestclick = _AM_RWBANNER_BANNER_EXIBREST;
            } else {
                $exibrestclick = round($lista_banners[$i]->getMaxclick() - $lista_banners[$i]->getClicks());
            }
            if ($lista_banners[$i]->getClicks() != 0 && $lista_banners[$i]->getExibicoes() != 0) {
                $perc = round(($lista_banners[$i]->getClicks() / $lista_banners[$i]->getExibicoes()) * 100, 2);
            } else {
                $perc = '0';
            }
            $data    = $lista_banners[$i]->getData();
            $periodo = $lista_banners[$i]->getPeriodo();
            $maxdata = somaData($data, $periodo);
            if ($periodo == 0) {
                $periodo = _AM_RWBANNER_BANNER_EXIBREST;
            } else {
                $periodo = converte($maxdata, 'BR', 0);
            }
            $titulo = $lista_banners[$i]->getBannnerCategName();
            $lista_banners[$i]->clearDb();
            $data_cad = converte($lista_banners[$i]->getData(), 'BR', 0);
            echo '
        <tr class="' . $class . '" ' . $estilo . '>
          <td align="center"><a href="javascript:void(0);" onclick="javascript: window.open(\'' . dirname(__DIR__) . '/admin/exibe.php?id=' . $lista_banners[$i]->getCodigo() . '\',\'editar\',\'width=' . ($lista_banners[$i]->getLargura() + 20) . ',height=' . $lista_banners[$i]->getAltura() . ',toolbar=no\');">' . $lista_banners[$i]->getCodigo() . '</a></td>
          <td align="center">' . $titulo . '</td>
          <td align="center">' . $lista_banners[$i]->getExibicoes() . '</td>
          <td align="center">' . $exibrest . '</td>
          <td align="center">' . $lista_banners[$i]->getClicks() . '</td>
          <td align="center">' . $exibrestclick . '</td>
          <td align="center">' . $perc . '%</td>
          <td align="center">' . $data_cad . '</td>
          <td align="center">' . $periodo . '</td>
          <td align="center">' . $status . '</td>';
            echo '
          <td align="center" width="10%">';
            echo ($xoopsModuleConfig['perm_client'] == 1) ? '<a href="inser.php?id=' . $lista_banners[$i]->getCodigo() . '&op=editar"><img src=' . $pathIcon16 . '/edit.png' . ' width="16" height="16" border="0" alt="' . _AM_RWBANNER_VALUE_BTN3 . '" title="' . _AM_RWBANNER_VALUE_BTN3 . '"></a>' : '';
            echo '<a href="index.php?id=' . $lista_banners[$i]->getCodigo() . '&op=sendemail"><img src=' . $pathIcon16 . '/mail_forward.png' . ' width="16" height="16" border="0" alt="' . _MD_EMAIL_STATS . '" title="' . _MD_EMAIL_STATS . '"></a>
          </td>
        </tr>';
        }
        if (substr($_SERVER['QUERY_STRING'], 0, 5) !== 'start') {
            $arr_qs    = explode('&', $_SERVER['QUERY_STRING']);
            $n         = (substr($arr_qs[count($arr_qs) - 1], 0, 5) !== 'start') ? $n = 1 : $n = 2;
            $extra_pag = '';
            for ($i = 0; $i <= count($arr_qs) - $n; ++$i) {
                $extra_pag .= $arr_qs[$i] . '&';
            }
            $extra_pag = substr($extra_pag, 0, - 1);
        } else {
            $extra_pag = '';
        }
        $pagenav = new XoopsPageNav($total, $limit, $start, 'start', $extra_pag);
        $pag     = $pagenav->renderNav();
        echo '  <tr class="head">';
        echo '    <td align="left" colspan="12" nowrap="nowrap" style="padding:5px;">' . _AM_RWBANNER_TOTAL_BANNER_LEG . ' ' . $total . '<br><div align="center">' . $pag . '</div></td>';
        echo '  </tr>';
        echo '</table>';
    } else {
        echo ($xoopsModuleConfig['show_cad_form'] == 1) ? '<p style="text-align:justify;">' . _MD_RWBANNER_MSG_INDEX_NOBANNER . '</p>' : '<p style="text-align:justify;">' . _MD_RWBANNER_MSG_INDEX_NOBANNER1 . '</p>';
    }
}
