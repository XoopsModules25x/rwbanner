#  ------------------------------------------------------------------------ #
#                                  RW-Banner                                #
#                    Copyright (c) 2006 BrInfo                              #
#                     <http:#www.brinfo.com.br>                             #
#  ------------------------------------------------------------------------ #
#  This program is free software; you can redistribute it and/or modify     #
#  it under the terms of the GNU General Public License as published by     #
#  the Free Software Foundation; either version 2 of the License, or        #
#  (at your option) any later version.                                      #
#                                                                           #
#  You may not change or alter any portion of this comment or credits       #
#  of supporting developers from this source code or any supporting         #
#  source code which is considered copyrighted (c) material of the          #
#  original comment or credit authors.                                      #
#                                                                           #
#  This program is distributed in the hope that it will be useful,          #
#  but WITHOUT ANY WARRANTY; without even the implied warranty of           #
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            #
#  GNU General Public License for more details.                             #
#                                                                           #
#  You should have received a copy of the GNU General Public License        #
#  along with this program; if not, write to the Free Software              #
#  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA #
# ------------------------------------------------------------------------- #
# Author: Rodrigo Pereira Lima (BrInfo - Soluções Web)                      #
# Site: http:#www.brinfo.com.br                                             #
# Project: RW-Banner                                                        #
# Descrição: Sistema de gerenciamento de mídias publicitárias               #
# ------------------------------------------------------------------------- #

# Table structure for table rw_banner
#

CREATE TABLE rw_banner (
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


#
# Table structure for table rw_categorias
#

CREATE TABLE rw_categorias (
  cod int(11) unsigned NOT NULL auto_increment,
  titulo varchar(50) default NULL,
  larg int(11) unsigned NOT NULL default '0',
  alt int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (cod)
) ENGINE=MyISAM;

#
# Dumping data for table rw_categorias
#

INSERT INTO rw_categorias VALUES (1,'468x60',468,60);
INSERT INTO rw_categorias VALUES (2,'120x60',120,60);

#
# Table structure for table rw_tags
#
CREATE TABLE rw_tags (
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

#
# Dumping data for table rw_tags
#
INSERT INTO rw_tags (id,title,name,categ,qtde,cols,modid,obs,status) VALUES (1,'RW-BANNER Default TAG','rw_banner',1,1,1,'a:1:{i:0;s:1:\"0\";}',"",1);
