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
	
	$imageDisplayHash = array();
	foreach ($pParams['imagesHash'] AS $key=>$imageParams){
		$imageParams['id'] = $imageParams['image_id'];
		// The Manditory Parameter is missing. we move on
		if(!empty( $imageParams['id'] ) && $imageParams['image_slideshow_inc'] ) {
			$imageCount++;
			//Grab image hash
			if( !$att = LibertyMime::getAttachment( $imageParams['id'], $imageParams )) {
				@error_log( tra( "Invalid attachment id in smarty_function_attachment: ".$imageParams['id'] ) );
				$ret = "FAIL";
				return $ret;
			}
			
			if( !empty( $att['is_mime'] )) {	
				if(empty($imageParams['image_pos'])){
					$imageParams['image_pos']= 1; 
				}
				$imageHash = array_merge($imageParams, $att);
				$imageDisplayHash[] = $imageHash;
			}
		}
	}
		
	//Sort the image hash
	$imageDisplayHashSorted = array_sort($imageDisplayHash,'image_pos');
	//Keep track of the image counts in the slideshow
	$imageCount = 0;
	foreach ($imageDisplayHashSorted AS $key=>$imageParams){		
		$imageCount++;
		//If first image, display an image anchor else display a hidden anchor
		if($imageCount == 1){
			$ret = $ret.' <a href="'.BIT_BASE_URI.$imageParams['thumbnail_url']['large'].'" rel="slideshow_'.$pParams['rel'].'" title="'.$imageParams['image_caption'].'"><img border=0 src="'.BIT_BASE_URI.$imageParams['thumbnail_url']['small'].'"/></a> ';
		}else{
			$ret = $ret.' <a href="'.BIT_BASE_URI.$imageParams['thumbnail_url']['large'].'" rel="slideshow_'.$pParams['rel'].'" title="'.$imageParams['image_caption'].'" visibility="hidden"></a> ';
		}
	}
	
	//HACK TO TEST THE SLIDESHOW
	$ret = $ret.' <a href="'.THEMES_PKG_URL.'icons/default-leftside-col.jpg" rel="slideshow_'.$pParams['rel'].'" title="" visibility="hidden"></a> ';
	return $ret;
}

//function to sort an array by a specific key. Maintains index association.
function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
