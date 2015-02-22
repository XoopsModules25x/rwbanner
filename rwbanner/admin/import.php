<?php

include( "admin_header.php" );
xoops_cp_header();

$op = (isset($_POST['op']))?$_POST['op']:'show';

switch ($op){
    case 'show':
         BannersAdmin();
         break;
    case 'import':
         import($_POST['import']);
         break;
}

function BannersAdmin()
{
    global $xoopsConfig, $xoopsModule;
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();
//    include "admin_header.php";
//    xoops_cp_header();
    $indexAdmin = new ModuleAdmin();
    echo $indexAdmin->addNavigation('import.php');
    include_once ("../class/class.categoria.php");
    $impmade = $imptotal = 0;
    $categ = new Categoria();
    $lista_categs = $categ->getCategorias('ORDER BY cod ASC');



    echo '<script>
          function pega(){
            myform = document.getElementsByTagName("input");
            selbox = document.getElementsByTagName("select");
            for (i=0; i<=myform.length-1; i++){
              if (myform[i].getAttribute("type") == "checkbox" && myform[i].getAttribute("id") != "selall"){
                var banid = myform[i].getAttribute("id");
                var uid = "rwuid"+myform[i].getAttribute("id");
                var categid = "categ"+myform[i].getAttribute("id");
                for (x=0; x<=selbox.length-1; x++){
                  if (selbox[x].getAttribute("id") == uid){
                    seluser = selbox[x].value;
                  }
                  if (selbox[x].getAttribute("id") == categid){
                    selcateg = selbox[x].value;
                  }
                }
                myform[i].value=banid+"|"+selcateg+"|"+seluser;
              }
            }
          }
          function Selall(sts){
            myform = document.getElementsByTagName("input");
            for (i=0; i<=myform.length-1; i++){
              if (myform[i].getAttribute("type") == "checkbox" && myform[i].getAttribute("id") != "selall"){
                myform[i].checked = sts;
              }
            }
          }
          </script>';



    echo '<form name="formimport" id="formimport" method="post" action="" onsubmit="return pega();">';
    echo "<div style='text-align:center'><b>"._AM_RWBANNER_IMPORT_TITLE."</b></div><br />
    <table width='100%' border='0' class='outer'><tr>
    <th align='center'>"._AM_RWBANNER_TITLE2."</td>
    <th align='center'>"._AM_RWBANNER_IMPORT_TITLE1."</td>
    <th align='center'>"._AM_RWBANNER_TITLE3."</td>
    <th align='center'>"._AM_RWBANNER_IMPORT_TITLE2."</td>
    <th align='center'>"._AM_RWBANNER_IMPORT_TITLE3."</td>";
    echo "</tr>";
    $result = $xoopsDB->query("SELECT bid, cid FROM ".$xoopsDB->prefix("banner")." ORDER BY bid");
    $myts = MyTextSanitizer::getInstance();
    $class = "";
    while(list($bid, $cid) = $xoopsDB->fetchRow($result)) {
        if ($class == "even")
          $class = "odd";
        else
          $class = "even";
        $result2 = $xoopsDB->query("SELECT cid, name FROM ".$xoopsDB->prefix("bannerclient")." WHERE cid=$cid");
        list($cid, $name) = $xoopsDB->fetchRow($result2);
        $name = $myts->htmlSpecialChars($name);
        if ( $impmade == 0 ) {
            $percent = 0;
        } else {
            $percent = substr(100 * $clicks / $impmade, 0, 5);
        }
        if ( $imptotal == 0 ) {
            $left = ""._AM_RWBANNER_UNLIMIT."";
        } else {
            $left = $imptotal-$impmade;
        }
        $categs = '<select name="categ'.$bid.'" id="categ'.$bid.'">';
        for ($i = 0; $i <= count($lista_categs)-1; $i++){
          $categs .= '<option value="'.$lista_categs[$i]->getCod().'">'.$lista_categs[$i]->getTitulo().'</option>';
        }
        $categs .= '</select>';
        $rwuid = '<select name="rwuid'.$bid.'" id="rwuid'.$bid.'">';
        $query = $xoopsDB->queryF("SELECT uid,uname FROM ".$xoopsDB->prefix("users").' ORDER BY uname ASC');
        while(list($uid,$uname) = $xoopsDB->fetchRow($query)){
          $rwuid .= '<option value="'.$uid.'">'.$uname.'</option>';
        }
        $rwuid .= '</select>';
        echo '<tr align="center" class="'.$class.'">';
        echo '<td align="center"><a href="javascript:;" onClick="javascript: window.open(\'exibe.php?id='.$bid.'&import=1\',\'editar\',\'width=488,height=80,toolbar=no\');">'.$bid.'</a></td>';
        echo "<td align='center'>$categs</td>";
        echo "<td align='center'>$name</td>";
        echo "<td align='center'>$rwuid</td>";
        echo "<td align='center'><input type='checkbox' name='import[]' id='$bid'></td>";
        echo "</tr>";
    }
    echo '<input type="hidden" name="op" value="import">';
    echo '<tr class="head"><td colspan="4" align="center"><input type="submit" value=' . _AM_RWBANNER_IMPORT . ' ></td><td align="center"><input type="checkbox" id="selall" onClick="Selall(this.checked);"></td></tr>';
    echo "</table></form>";
    //xoops_cp_footer();
    include_once 'admin_footer.php';
}

function import($dados){
  global $xoopsDB;
  include_once ("../class/class.banner.php");
  
  $banners = array();
  for ($i = 0; $i <= count($dados)-1; $i++){
    $ban = explode("|", $dados[$i]);
    $query = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("banner")." WHERE bid=".$ban[0]);
    $row = $xoopsDB->fetchArray($query);
    $banners[$i]['categoria'] = $ban[1];
    $banners[$i]['titulo'] = '';
    $banners[$i]['texto'] = '';
    $banners[$i]['url'] = $row['clickurl'];
    $banners[$i]['grafico'] = $row['imageurl'];
    $banners[$i]['usarhtml'] = $row['htmlbanner'];
    $banners[$i]['htmlcode'] = $row['htmlcode'];
    $banners[$i]['showimg'] = 1;
    $banners[$i]['exibicoes'] = $row['impmade'];
    $banners[$i]['maxebib'] = $row['imptotal'];
    $banners[$i]['clicks'] = $row['clicks'];
    $banners[$i]['maxclick'] = 0;
    $banners[$i]['data'] = date('Y-m-d',$row['date']);
    $banners[$i]['periodo'] = 0;
    $banners[$i]['status'] = 1;
    $banners[$i]['target'] = '_blank';
    $banners[$i]['idcliente'] = $ban[2];
    $banners[$i]['obs'] = '';
  }
  $errors = 0;
  for ($i = 0; $i <= count($banners)-1; $i++){
    $banner = new RWbanners($banners[$i]);
    if (!$banner->grava())
      $errors++;
  }
  if($errors)
    redirect_header('index.php',2,_AM_RWBANNER_FAIL_IMPORT);
  else
    redirect_header('index.php',2,_AM_RWBANNER_SUCCESS_IMPORT);
}
