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

class Categoria
{
    public $db;
    public $cod;
    public $titulo;
    public $larg;
    public $alt;
    public $errormsg;

    //Construtor
    function __construct($dados=null, $id = null)
    {
        if ($dados == null && $id != null){
          $this->db = &XoopsDatabaseFactory::getDatabaseConnection();
          $sql = 'SELECT * FROM '.$this->db->prefix('rw_categorias').' WHERE cod='.$id;
          $query = $this->db->query($sql);
          $row = $this->db->fetchArray($query);
          
          $this->cod = $row['cod'];
          $this->titulo = $row['titulo'];
          $this->larg = $row['larg'];
          $this->alt = $row['alt'];
        }elseif ($dados != null){
          $this->cod = (!empty($dados['cod']))?$dados['cod']:'';
          $this->titulo = (!empty($dados['titulo']))?$dados['titulo']:'';
          $this->larg = (!empty($dados['larg']))?$dados['larg']:'';
          $this->alt = (!empty($dados['alt']))?$dados['alt']:'';
        }else{
          $this->cod = '';
          $this->titulo = '';
          $this->larg = '';
          $this->alt = '';
        }
    }
    // Métodos get e set de todos os atributos
    function setCod($cod)
    {
        $this->cod = $cod;
    }
    function getCod()
    {
        return $this->cod;
    }
    
    function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    function getTitulo()
    {
        return $this->titulo;
    }
    
    function setLarg($larg)
    {
        $this->larg = $larg;
    }
    function getLarg()
    {
        return $this->larg;
    }
    
    function setAlt($alt)
    {
        $this->alt = $alt;
    }
    function getAlt()
    {
        return $this->alt;
    }

    function setError($error)
    {
        $this->errormsg = $error;
    }
    function getError()
    {
        return $this->errormsg;
    }
    //fim métodos set e get dos atributos
    
    function clearDb(){
         $this->db = null;
    }
    
    //Insere uma nova categoria no banco de dados
    function grava(){
        $this->db = &XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'INSERT INTO '.$this->db->prefix('rw_categorias').' (titulo, larg, alt) VALUES ("'.$this->titulo.'", "'.$this->larg.'", "'.$this->alt.'")';
        if ($query = $this->db->queryF($sql))
          return true;
        else{
          $this->setError($this->db->error());

          return false;
        }
    }

    //Edita a categoria instanciada e salva as alterações no banco de dados
    function edita(){
        $this->db = &XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'UPDATE '.$this->db->prefix('rw_categorias').' SET titulo="'.$this->titulo.'", larg="'.$this->larg.'", alt="'.$this->alt.'" WHERE cod= '.$this->cod;
        if ($query = $this->db->queryF($sql))
          return true;
        else{
          $this->setError($this->db->error());

          return false;
        }
    }

    //Exclui a categoria instanciada do banco de dados e exclui também os banners dessa categoria.
    function exclui(){
        $this->db = &XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'SELECT codigo FROM '.$this->db->prefix('rw_banner').' WHERE categoria='.$this->cod;
        $query = $this->db->query($sql);
        while(list($idbanner) = $this->db->fetchRow($query)){
          $this->db->queryF('DELETE FROM '.$this->db->prefix('rw_banner').' WHERE codigo= '.$idbanner);
        }
        $sql = 'DELETE FROM '.$this->db->prefix('rw_categorias').' WHERE cod= '.$this->cod;
        if ($query = $this->db->queryF($sql))
          return true;
        else{
          $this->setError($this->db->error());

          return false;
        }
    }
    
    //Retorna um array associativo de todas as categorias encontradas.
    function getCategorias($order){
        $this->db = &XoopsDatabaseFactory::getDatabaseConnection();
        $extra = ($order != null)?' '.$order:'';
        $sql = 'SELECT cod FROM '.$this->db->prefix('rw_categorias').$extra;
        $query = $this->db->query($sql);
        $categs = array();
        while(list($id) = $this->db->fetchRow($query)){
          $categ = new Categoria(null,$id);
            unset($categ->db);
            unset($categ->errormsg);
            $categs[] =& $categ;
            unset($categ);
        }

        return $categs;
    }
}
