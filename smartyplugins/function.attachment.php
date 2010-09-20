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
 * File: block.attachment.php 
 * Type: block 
 * Name: attachment 
 * ------------------------------------------------------------- 
 *
 * @param int 		id 		then attachment_id
 * @param string 	size 	the thumbnail size (can be 'original')
 * @param string	link	what to link to [false, <thumbsize>, download (direct download), <url>] 
 */ 

function smarty_function_attachment( $pParams, &$gBitSmarty ) {
	require_once( LIBERTY_PKG_PATH.'LibertyMime.php' );

	// at a minimum, return blank string (not empty) so we still replace the tag
	$ret = ' ';

	// The Manditory Parameter is missing. we are not gonna throw an error, and 
	// just return empty
	if( empty( $pParams['id'] )) {
		return $ret;
	}

	if( !$att = LibertyMime::getAttachment( $pParams['id'], $pParams )) {
		@error_log( tra( "Invalid attachment id in smarty_function_attachment: ".$pParams['id'] ) );
		$ret = "FAIL";
		return $ret;
	}

	// override the icon since thumbnails dont use bit icon 
	// this allows one to override the mime icons in liberty
	if( !empty( $pParams['thumbnail_url'] ) ){
		foreach( $att['thumbnail_url'] as $key=>$url ){
			$att['thumbnail_url'][$key] = $pParams['thumbnail_url'];
		}
	}

	if( !empty( $att['is_mime'] )) {
		global $gLibertySystem;
		// convert parameters into display properties
		$wrapper = liberty_plugins_wrapper_style( $pParams );
		// work out custom display_url if there is one
		if( @BitBase::verifyId( $pParams['content_id'] )) {
			// link to any content by content_id
			if( $obj = LibertyBase::getLibertyObject( $pParams['content_id'] )) {
				$wrapper['display_url'] = $obj->getDisplayUrl();
			}
		} elseif( !empty( $pParams['link'] ) && $pParams['link'] == 'false' ) {
			// no link
		} elseif( !empty( $pParams['link'] )) {
			// Allow the use of icon, avatar, small, medium and large to link to certain size of image directly
			if( !empty( $att['thumnail_url'][$pParams['link']] )) {
				$pParams['link'] = $att['thumnail_url'][$pParams['link']];

			// Allow the use of 'original' to link to original file directly
			} elseif( $pParams['link'] == 'original' && !empty( $att['source_url'] )) {
				$pParams['link'] = $att['source_url'];

			// Allow the use of 'download' to link to download link. this will allow us to count downloads
			} elseif( $pParams['link'] == 'download' && !empty( $att['download_url'] )) {
				$pParams['link'] = $att['download_url'];

			// Adjust class name if we are leaving this server
			} elseif( !strstr( $pParams['link'], $_SERVER["SERVER_NAME"] ) && strstr( $pParams['link'], '//' )) {
				$wrapper['href_class'] = 'class="external"';
			}
			$wrapper['display_url'] = $pParams['link'];
		} else {
			$wrapper['display_url'] = $att['display_url'];
		}

		/*
		if( !empty( $wrapper['description'] )) {
			$parseHash['content_id'] = $pParseHash['content_id'];
			$parseHash['user_id']    = $pParseHash['user_id'];
			$parseHash['no_cache']   = TRUE;
			$parseHash['data']       = $wrapper['description'];
			$wrapper['description_parsed'] = $pCommonObject->parseData( $parseHash );
		}
		*/

		// pass stuff to the template
		$gBitSmarty->assign( 'attachment', $att );
		$gBitSmarty->assign( 'wrapper', $wrapper );
		$gBitSmarty->assign( 'thumbsize', (( !empty( $pParams['size'] ) && ( $pParams['size'] == 'original' || !empty( $att['thumbnail_url'][$pParams['size']] ))) ? $pParams['size'] : 'medium' ));

		//Carry only these attributes to the image tags
		$width = !empty( $pParams['width'] ) ? $pParams['width'] : '';
		$gBitSmarty->assign( 'width', $width );

		$height = !empty( $pParams['height'] ) ? $pParams['height'] : '';
		$gBitSmarty->assign( 'height', $height );

		$mimehandler = (( !empty( $wrapper['output'] ) && $wrapper['output'] == 'thumbnail' ) ? LIBERTY_DEFAULT_MIME_HANDLER : $att['attachment_plugin_guid'] );
		$gBitSmarty->display( $gLibertySystem->getMimeTemplate( 'attachment', $mimehandler ));
	}
	return $ret;
}
