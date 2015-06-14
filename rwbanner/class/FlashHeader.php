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

/**
* Flash Header reader
* Alessandro Crugnola (sephiroth)
* alessandro@sephiroth.it
* http://www.sephiroth.it
*
* Read the SWF header informations and return an
* associative array with the property of the SWF File
*
* @param input string file
* @returns array
*
*
* How to use
* -------------------------------------
* $f = new FlashHeader("flash.swf");
* $result = $f->getimagesize();
* print_r($result);
* -------------------------------------
*
*/
class FlashHeader{
    public $version;
    public $filetype;
    public $bitpos;
    public $cur;
    public $pos;
    public $rect;
    public $framerate;
    public $length;
    public $compression = 0;
    public $point = 0;
    public $isValid = 0;
    /**
    * @method FlashHeader
    * @type constructor
    * @param string file
    */
    function FlashHeader($buffer){
        $this->buffer = $buffer;
        $fp = @fopen($this->buffer,"rb");
        $head = @fread($fp, 3);
        if($head == "CWS"){
            /* zlib */
            fseek($fp,0);
            $data = fread($fp,8);
            $_data = gzuncompress(fread($fp, filesize($buffer)));
            $data = $data . $_data;
            $this->data = $data;
            $this->compression = 1;
            $this->isValid = 1;
        } else if ($head == "FWS"){
            fseek($fp,0);
            $this->data = fread($fp, filesize($buffer));
            $this->isValid = 1;
        } else {
            $this->isValid = 0;
        }
        @fclose($fp);
    }
    
    /**
    * @method getimagesize
    * @type public
    * @description read the file informations
    */
    function getimagesize(){
        if(!$this->isValid){
            return false;
        }
        $this->filetype = $this->read(3);
        $this->version =  $this->readbyte();
        $l = $this->read(4);
        $this->filelength = filesize($this->buffer);
        $this->rect = $this->readRect();
        $this->framerate = unpack('vrate',$this->read(2));
        $this->framerate = $this->framerate['rate']/256;
        $this->framecount = $this->readshort();

        return array(
                        "zlib-compression"=> $this->compression,
                        "fileType" => $this->filetype,
                        "version" => $this->version,
                        "fileSize" => $this->filelength,
                        "frameRate" => $this->framerate,
                        "frameCount" => $this->framecount,
                        "movieSize" => $this->rect
                    );
    }
    
    /* read */
    function read($n){
        $ret = substr($this->data, $this->point, $this->point + $n);
        $this->point += $n;

        return $ret;
    }
    
    /* read short */
    function readshort(){
        $pack = unpack('vshort',$this->read(2));

        return $pack['short'];
    }
    
    /* read byte */
    function readByte(){
        $ret = unpack("Cbyte",$this->read(1));

        return $ret['byte'];
    }
    /* read Rect */
    function readRect(){
        $this->begin();
        $l = $this->readbits(5);
        $xmin = $this->readbits($l)/20;
        $xmax = $this->readbits($l)/20;
        $ymin = $this->readbits($l)/20;
        $ymax = $this->readbits($l)/20;
        $rect = new Rect($xmax, $ymax);

        return $rect->__str__();
    }
    /* incpos */
    function incpos(){
        $this->pos += 1;
        if($this->pos>8){
            $this->pos = 1;
            $this->cur = $this->readbyte();
        }
    }
    
    
    /* readbits */
    function readbits($nbits){
        $n = 0;
        $r = 0;
        while($n < $nbits){
            $r = ($r<<1) + $this->getbits($this->pos);
            $this->incpos();
            $n += 1;
        }

        return $r;
    }
    
    /* getbits */
    function getbits($n){
        return ($this->cur>>(8-$n))&1;
    }
    
    /* begin */
    function begin(){
        $this->cur = $this->readbyte();
        $this->pos = 1;
    }
    
}

/**
* class Rect
* store the size values into an associative array
*/
class Rect{
    function Rect($x2,$y2){
        $this->xmax = $x2;
        $this->ymax = $y2;
        $this->value = $this->__str__();
    }
    function __str__(){
        $ret = array($this->xmax, $this->ymax);
        $ret["width"] = $this->xmax;
        $ret["height"] = $this->ymax;

        return $ret;
    }
}
/* end */
