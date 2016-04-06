<?php
/*
                                  RW-Banner
                          Copyright (c) 2006 BrInfo
                          <http://www.brinfo.com.br>
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  You may not change or alter any portion of this comment or credits
  of supporting developers from this source code or any supporting
  source code which is considered copyrighted (c) material of the
  original comment or credit authors.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
*/
/**
 * XOOPS rwbanner Upgrade
 *
 * @copyright::  {@link www.brinfo.com.br BrInfo - Soluções Web}
 * @license  ::    {@link http://www.fsf.org/copyleft/gpl.html GNU public license}
 * @author   ::     Rodrigo Pereira Lima aka RpLima (http://www.brinfo.com.br)
 * @package  ::    rwbanner
 * @since    ::      1.0
 *
 */

include_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
xoops_cp_header();
include_once dirname(__DIR__) . '/include/functions.php';

if (is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid())) {
    $errors = 0;

    //Checa se a tabela ds banners existe, caso n?o exista cria.
    if (!rwTableExists($xoopsDB->prefix('rw_banner'))) {
        $sql = '
    CREATE TABLE ' . $xoopsDB->prefix('rw_banner') . " (
      codigo int(11) NOT NULL auto_increment,
      categoria int(11) default NULL,
      titulo varchar(255) default NULL,
      texto text,
      url varchar(255) default NULL,
      grafico varchar(255) default NULL,
      usarhtml int(1) default NULL,
      htmlcode text,
      showimg int(1) NOT NULL default '1',
      exibicoes int(11) default NULL,
      maxexib int(11) NOT NULL default '0',
      clicks int(11) default NULL,
      maxclick int(11) NOT NULL default '0',
      data datetime default NULL,
      periodo int(5) NOT NULL default '0',
      status int(1) unsigned NOT NULL default '1',
      target varchar(50) default '_blank',
      idcliente int(11) default NULL,
      obs text,
      PRIMARY KEY  (`codigo`)
    ) ENGINE=MyISAM;
    ";
        if (!$xoopsDB->queryF($sql)) {
            echo '<br />' . _AM_RWBANNER_UPGRADEFAILED1;
            ++$errors;
        }
    } else {
        if (!rwFieldExists('titulo', $xoopsDB->prefix('rw_banner'))) {
            rwAddField('titulo varchar(255) default NULL AFTER categoria', $xoopsDB->prefix('rw_banner'));
        }
        if (!rwFieldExists('texto', $xoopsDB->prefix('rw_banner'))) {
            rwAddField('texto text AFTER titulo', $xoopsDB->prefix('rw_banner'));
        }
        if (!rwFieldExists('showimg', $xoopsDB->prefix('rw_banner'))) {
            rwAddField("showimg int(1) NOT NULL default '1' AFTER htmlcode", $xoopsDB->prefix('rw_banner'));
        }
        if (!rwFieldExists('periodo', $xoopsDB->prefix('rw_banner'))) {
            rwAddField("periodo int(5) NOT NULL default '0' AFTER data", $xoopsDB->prefix('rw_banner'));
        }
        if (!rwFieldExists('obs', $xoopsDB->prefix('rw_banner'))) {
            rwAddField('obs text AFTER idcliente', $xoopsDB->prefix('rw_banner'));
        }
        if (!rwFieldExists('maxclick', $xoopsDB->prefix('rw_banner'))) {
            rwAddField("maxclick int(11) NOT NULL default '0' AFTER clicks", $xoopsDB->prefix('rw_banner'));
        }
    }

    if (!rwTableExists($xoopsDB->prefix('rw_categorias'))) {
        $sql = '
    CREATE TABLE ' . $xoopsDB->prefix('rw_categorias') . " (
      cod int(11) unsigned NOT NULL auto_increment,
      titulo varchar(50) default NULL,
      larg int(11) unsigned NOT NULL default '0',
      alt int(11) unsigned NOT NULL default '0',
      PRIMARY KEY  (cod)
    ) ENGINE=MyISAM;
    ";
        if (!$xoopsDB->queryF($sql)) {
            echo '<br />' . _AM_RWBANNER_UPGRADEFAILED2;
            ++$errors;
        }
    } else {
        if (rwFieldExists('modid', $xoopsDB->prefix('rw_categorias'))) {
            rwRemoveField('modid', $xoopsDB->prefix('rw_categorias'));
        }
    }

    if (!rwTableExists($xoopsDB->prefix('rw_tags'))) {
        $sql = '
    CREATE TABLE ' . $xoopsDB->prefix('rw_tags') . " (
      id int(11) NOT NULL auto_increment,
      title varchar(255) default NULL,
      name varchar(255) NOT NULL default 'rw_banner',
      codbanner int(5) default NULL,
      categ int(5) NOT NULL default '1',
      qtde int(5) NOT NULL default '1',
      cols int(5) NOT NULL default '1',
      modid text,
      obs text,
      status int(1) NOT NULL default '1',
      PRIMARY KEY  (id)
    ) ENGINE=MyISAM;
    ";
        if (!$xoopsDB->queryF($sql)) {
            echo '<br />' . _AM_RWBANNER_UPGRADEFAILED3;
            ++$errors;
        }
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('rw_tags') . ' (id,title,name,codbanner,categ,qtde,cols,modid,obs,status) VALUES (1,"RW-BANNER Default TAG","rw_banner","",1,1,1,"a:1:{i:0;s:1:\"0\";}","",1)';
        if (!$xoopsDB->queryF($sql)) {
            echo '<br />' . _AM_RWBANNER_UPGRADEFAILED3;
            ++$errors;
        }
    }

    if ($errors) {
        echo '<h1>' . _AM_RWBANNER_UPGRADEFAILED . "</h1>\n";
    } else {
        echo _AM_RWBANNER_UPGRADECOMPLETE . " - <a href='" . XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module='. basename(dirname(__DIR__)) .'>" . _AM_RWBANNER_UPDATEMODULE . '</a>';
        echo '<p style="text-align:justify;">' . _AM_RWBANNER_UPGRADECOMPLETE1 . '</p>';
        echo '<pre>\n';
        print('
      #######################################################################################
      #### Hack by rw-banner
      #### Cria variáveis smarty para exibir banner no tema do site e nos templates
      #######################################################################################
      $mod = XoopsModule::getByDirname(basename(dirname(__DIR__)));
      if ($mod) {
        include_once (dirname(__DIR__) .\'/include/maketags.php\');
      }
      #######################################################################################
      #### Fim do Hack by rw-banner
      #######################################################################################
    ');
        echo "</pre>\n";
        echo "<p style='text-align: justify;'>" . _AM_RWBANNER_UPGRADECOMPLETE2 . "</p>\n";
        echo "<pre>\n";
        print('
      #######################################################################################
      #### Hack by rw-banner
      #### Permite a exibição de banners randomicos em qualquer módulo que aceite bbcodes
      #######################################################################################
      $mod = XoopsModule::getByDirname(basename(dirname(__DIR__)));
      if ($mod) {
        include(dirname(__DIR__) .\'/include/bbcode.php\');
      }
      #######################################################################################
      #### Fim do Hack by rw-banner
      #######################################################################################
    ');
        echo "</pre>\n";
    }
} else {
    printf("<h2>%s</h2>\n", _MD_RWBANNER_NOPERM);
}
