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
 * @param rel				string 		unique rel value for this slideshow instance
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
	$ret = $ret.' <script>var $jq = jQuery.noConflict();$jq(document).ready(function(){$jq("a[rel=\'slideshow_'.$pParams['rel'].'\']").colorbox({slideshow:false,slideshowAuto:false});});</script>';
	//Keep track of the image counts in the slideshow
	$imageCount = 0;
	foreach ($pParams['imagesHash'] AS $key=>$imageParams){
		$imageParams['id'] = $imageParams['image_id'];
		// The Manditory Parameter is missing. we move on
		if(!empty( $imageParams['id'] )) {
			//Grab image hash
			if( !$att = LibertyMime::getAttachment( $imageParams['id'], $imageParams )) {
				@error_log( tra( "Invalid attachment id in smarty_function_attachment: ".$imageParams['id'] ) );
				$ret = "FAIL";
				return $ret;
			}
			
			if( !empty( $att['is_mime'] )) {	
				$imageSize = !empty( $pParams['image_size'] ) && !empty( $att['thumbnail_url'][$pParams['image_size']] ) ?$pParams['image_size']:'large';
				$thumbnailSize = !empty( $pParams['thumbnail_size'] ) && !empty( $att['thumbnail_url'][$pParams['thumbnail_size']] ) ?$pParams['thumbnail_size']:'small';
				$imageCount++;
				//If first image, display an image anchor else display a hidden anchor
				if($imageCount == 1){
					$ret = $ret.' <a href="'.BIT_BASE_URI.$att['thumbnail_url'][$imageSize].'" rel="slideshow_'.$pParams['rel'].'" title="'.$imageParams['image_caption'].'"><img border=0 src="'.BIT_BASE_URI.$att['thumbnail_url'][$thumbnailSize].'"/></a> ';
				}else{
					$ret = $ret.' <a href="'.BIT_BASE_URI.$att['thumbnail_url'][$imageSize].'" rel="slideshow_'.$pParams['rel'].'" title="'.$imageParams['image_caption'].'" visibility="hidden"></a> ';
				}
			}
		}
	}
	return $ret;
}
