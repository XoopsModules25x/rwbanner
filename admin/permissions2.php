<?php
include_once( '../../../include/cp_header.php' ) ;
include_once( 'mygrouppermform.php' ) ;
include_once( XOOPS_ROOT_PATH.'/class/xoopsblock.php' ) ;
//include_once "../include/gtickets.php" ;// GIJ
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/include/functions.php";

$xoops_system_path = XOOPS_ROOT_PATH . '/modules/system' ;

// language files
$language = $xoopsConfig['language'] ;
if( ! file_exists( "$xoops_system_path/language/$language/admin/blocksadmin.php") ) $language = 'english' ;

// to prevent from notice that constants already defined
$error_reporting_level = error_reporting( 0 ) ;
include_once( "$xoops_system_path/constants.php" ) ;
include_once( "$xoops_system_path/language/$language/admin.php" ) ;
include_once( "$xoops_system_path/language/$language/admin/blocksadmin.php" ) ;
include_once dirname(dirname(__FILE__)) ."/language/$language/modinfo.php"  ;

error_reporting( $error_reporting_level ) ;

$group_defs = file( "$xoops_system_path/language/$language/admin/groups.php" ) ;
foreach( $group_defs as $def ) {
    if( strstr( $def , '_AM_RWBANNER_ACCESSRIGHTS' ) || strstr( $def , '_AM_RWBANNER_ACTIVERIGHTS' ) ) eval( $def ) ;
}

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( XOOPS_URL.'/user.php' , 1 , _MD_RWBANNER_NOPERM ) ;

// set target_module if specified by $_GET['dirname']
$module_handler =& xoops_gethandler('module');
if( ! empty( $_GET['dirname'] ) ) {
    $target_module =& $module_handler->getByDirname($_GET['dirname']);
}
// check access right (needs system_admin of BLOCK)
$sysperm_handler =& xoops_gethandler('groupperm');
if (!$sysperm_handler->checkRight('system_admin', XOOPS_SYSTEM_BLOCK, $xoopsUser->getGroups())) redirect_header( XOOPS_URL.'/user.php' , 1 , _MD_RWBANNER_NOPERM ) ;

function list_groups()
{
    global $target_mid , $target_mname , $block_arr, $xoopsModule ;

    $myts = &MyTextSanitizer::getInstance();

    rwbanner_collapsableBar('bottomtable', 'bottomtableicon');

    foreach( array_keys( $block_arr ) as $i ) {
        $item_list[ $block_arr[$i]->getVar("bid") ] = $block_arr[$i]->getVar("title") ;
    }

    $form = new MyXoopsGroupPermForm('' , 1 , 'block_read' , "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_RWBANNER_GROUPS . "</h3><div id='bottomtable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">" . _AM_RWBANNER_GROUPSINFO . "</span>") ;
    $form->addAppendix('module_admin',$xoopsModule->mid(),$myts->displayTarea($xoopsModule->name()).' '._AM_RWBANNER_ACTIVERIGHTS);
    $form->addAppendix('module_read',$xoopsModule->mid(),$myts->displayTarea($xoopsModule->name()).' '._AM_RWBANNER_ACCESSRIGHTS);
    foreach( $item_list as $item_id => $item_name) {
        $form->addItem( $item_id , $myts->displayTarea($item_name) ) ;
    }
    echo $form->render() ;
    echo "</div>";
}

if( ! empty( $_POST['submit'] ) ) {

    include( "mygroupperm.php" ) ;
    redirect_header( XOOPS_URL."/modules/".$xoopsModule->dirname()."/admin/myblocksadmin.php$query4redirect" , 1 , _MD_AM_DBUPDATED );
}

xoops_cp_header() ;

//echo '<br><br><br><br><br><br>';
list_groups() ;
xoops_cp_footer() ;
