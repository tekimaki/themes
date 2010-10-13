<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * @link http://www.bitweaver.org/wiki/blurb blurb
 */

/** 
 * Smarty plugin 
 * ------------------------------------------------------------- 
 * File: blurb.php 
 * Type: blurb 
 * Name: blurb 
 * ------------------------------------------------------------- 
 *
 * @param string 	blurb_guid 		the unique blurb guid
 * @param boolean 	title 			whether the title should be displayed or not
 */ 

function smarty_function_blurb( $pParams, &$gBitSmarty ) {
	require_once('function.biticon.php');
	require_once( BLURB_PKG_PATH.'BitBlurb.php' );
	// at a minimum, return blank string (not empty) so we still replace the tag
	$ret = ' ';
	// The Manditory Parameter is missing. we are not gonna throw an error, and 
	// just return empty
	if( empty( $pParams['blurb_guid'] )) {
		return $ret;
	}
	//Load up the blurb class
	$BitBlurb  = new BitBlurb( );
	
	//Grab the blurb id from the database. If not exist, return error
	$blurb_id = $BitBlurb->getIdByLookUp(array("blurb_guid"=>$pParams['blurb_guid']);
	if( empty( $blurb_id ) ) {
		@error_log( tra( "'No blurb found with the name: ')".$pParams['blurb_guid'] ) );
		$ret = "FAIL";
		return $ret;
	} else {
		//Set the class variable blurb id and load up the contents
		$BitBlurb->mBlurbId = $blurb_id;
		$BitBlurb ->load();
	}
	
	//Check if title should be displayed and assign it appropriatly
	$ret .= '<div class="blurb" id="'.$pParams['blurb_guid'].'">';
	if( !empty($pParams['title']) ) {
		$ret .= "<h3>".$BitBlurb ->mInfo['title']."</h3>";
	}
	//Extract the blurb
	$ret .= $BitBlurb ->mInfo['data'];
	// Allow user to edit blurb if they have permission to do so
	if( $BitBlurb->isValid() && ($BitBlurb->verifyUpdatePermission() || $BitBlurb->verifyCreatePermission())){
		$ret .="<a href=\"".BLURB_PKG_URL."edit_blurb.php?blurb_id=".$blurb_id."\" >".smarty_function_biticon(array('ipackage'=>'icons', 'iname'=>'accessories-text-editor', 'iexplain'=>'Edit'.$pParams['blurb_guid']),$gBitSmarty)."</a>";
	}
	$ret .= "</div>";
	return $ret;
}