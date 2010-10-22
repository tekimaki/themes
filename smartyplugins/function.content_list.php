<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * @link http://www.bitweaver.org/wiki/block_attachment block_attachment
 */

function smarty_function_content_list( $pParams, &$gBitSmarty ) {
	// at a minimum, return blank string (not empty) so we still replace the tag
	$ret = ' ';

	// some content specific offsets and pagination settings
	if( !empty( $pParams['sort_mode'] )) {
		$content_sort_mode = $pParams['sort_mode'];
	}

	$max_content = ( !empty( $pParams['max_records'] )) ? $pParams['max_records'] : $gBitSystem->getConfig( 'max_records',10 );

	$cListRequest = $pParams;

	// now that we have all the offsets, we can get the content list
	include_once( LIBERTY_PKG_PATH.'get_content_list_inc.php' );

	if( !empty( $contentList ) ){
		$gBitSmarty->assign( 'contentList',$contentList );
		$ret = $gBitSmarty->fetch( 'bitpackage:liberty/simple_list_generic_inc.tpl' );
	}

	return $ret;
}
