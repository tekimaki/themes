<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * @link http://www.bitweaver.org/wiki/block_attachment block_attachment
 */

/** 
 * Smarty plugin 
 * ------------------------------------------------------------- 
 * File: block.slideshow.php 
 * Type: block 
 * Name: slideshow 
 * ------------------------------------------------------------- 
 *
 * @param imageHash 		array 		hash of all the images to be added to slideshow
 */ 

function smarty_function_slideshow( $pParams, &$gBitSmarty ) {
	require_once( LIBERTY_PKG_PATH.'LibertyMime.php' );
	
	// at a minimum, return blank string (not empty) so we still replace the tag
	$ret = ' ';
	
	//If has is empty, return blank
	if( empty( $pParams )) {
		return $ret;
	}
	
	//Initiate the slideshow code in js
	//@TODO set 'rel' to something dynamic
	$ret = $ret.' <script>var $jq = jQuery.noConflict();$jq(document).ready(function(){$jq("a[rel=\'slideshow\']").colorbox({slideshow:false,slideshowAuto:false});});</script>';
	
	//Keep track of the image counts in the slideshow
	$imageCount = 0;
	
	foreach ($pParams['imagesHash'] AS $key=>$imageParams){
		//@TODO figure out how to grab a generalized image params
		$imageParams['id'] = $imageParams['about_image_id'];
		// The Manditory Parameter is missing. we move on
		if(!empty( $imageParams['id'] ) && $imageParams['about_image_slideshow_inc'] ) {
			$imageCount++;
			//Grab image hash
			if( !$att = LibertyMime::getAttachment( $imageParams['id'], $imageParams )) {
				@error_log( tra( "Invalid attachment id in smarty_function_attachment: ".$imageParams['id'] ) );
				$ret = "FAIL";
				return $ret;
			}
			
			if( !empty( $att['is_mime'] )) {	
				//If first image, display an image anchor else display a hidden anchor
				if($imageCount == 1){
					$ret = $ret.' <a href="'.BIT_BASE_URI.$att['thumbnail_url']['large'].'" rel="slideshow" title="'.$imageParams['about_image_caption'].'"><img border=0 src="'.BIT_BASE_URI.$att['thumbnail_url']['small'].'"/></a> ';
				}else{
					$ret = $ret.' <a href="'.BIT_BASE_URI.$att['thumbnail_url']['large'].'" rel="slideshow" title="'.$imageParams['about_image_caption'].'" visibility="hidden"></a> ';
				}
			}
		}
	}
	//HACK TO TEST THE SLIDESHOW
	$ret = $ret.' <a href="'.THEMES_PKG_URL.'icons/default-leftside-col.jpg" rel="slideshow" title="" visibility="hidden"></a> ';
	return $ret;
}
