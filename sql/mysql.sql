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
  codigo    INT(11)         NOT NULL AUTO_INCREMENT,
  categoria INT(11)                  DEFAULT NULL,
  titulo    VARCHAR(255)             DEFAULT NULL,
  texto     TEXT,
  url       VARCHAR(255)             DEFAULT NULL,
  grafico   VARCHAR(255)             DEFAULT NULL,
  usarhtml  INT(1)                   DEFAULT NULL,
  htmlcode  TEXT,
  showimg   INT(1)          NOT NULL DEFAULT '1',
  exibicoes INT(11)                  DEFAULT NULL,
  maxexib   INT(11)         NOT NULL DEFAULT '0',
  clicks    INT(11)                  DEFAULT NULL,
  maxclick  INT(11)         NOT NULL DEFAULT '0',
  data      DATETIME                 DEFAULT NULL,
  periodo   INT(5)          NOT NULL DEFAULT '0',
  status    INT(1) UNSIGNED NOT NULL DEFAULT '1',
  target    VARCHAR(50)              DEFAULT '_blank',
  idcliente INT(11)                  DEFAULT NULL,
  obs       TEXT,
  PRIMARY KEY (`codigo`)
)
  ENGINE = MyISAM;

#
# Table structure for table rw_categorias
#

CREATE TABLE rw_categorias (
  cod    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(50)               DEFAULT NULL,
  larg   INT(11) UNSIGNED NOT NULL DEFAULT '0',
  alt    INT(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (cod)
)
  ENGINE = MyISAM;

#
# Dumping data for table rw_categorias
#

INSERT INTO rw_categorias VALUES (1, '468x60', 468, 60);
INSERT INTO rw_categorias VALUES (2, '120x60', 120, 60);

#
# Table structure for table rw_tags
#
CREATE TABLE rw_tags (
  id        INT(11)      NOT NULL AUTO_INCREMENT,
  title     VARCHAR(255)          DEFAULT NULL,
  name      VARCHAR(255) NOT NULL DEFAULT 'rw_banner',
  codbanner INT(5)                DEFAULT NULL,
  categ     INT(5)       NOT NULL DEFAULT '1',
  qtde      INT(5)       NOT NULL DEFAULT '1',
  cols      INT(5)       NOT NULL DEFAULT '1',
  modid     TEXT,
  obs       TEXT,
  status    INT(1)       NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM;

#
# Dumping data for table rw_tags
#
INSERT INTO rw_tags (id, title, name, categ, qtde, cols, modid, obs, status) VALUES (1, 'RW-BANNER Default TAG', 'rw_banner', 1, 1, 1, 'a:1:{i:0;s:1:\"0\";}', '', 1);
