<?php 
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {form} block plugin
 *
 * Type:     block
 * Name:     form
 * Input:
 *           - legend      (optional) - text that appears in the legend
 */
function smarty_block_legend($params, $content, &$gBitSmarty) {
	// default to use inlineLabels in uniForm
	if( !$params['floathelp'] ){
		$params['class'] = !empty( $params['class'] )?$params['class'].' inlineLabels':'inlineLabels';
	}
	if( $content ) {
		$attributes = '';
		$attributes .= !empty( $params['class'] ) ? ' class="'.$params['class'].'" ' : '' ;
		$attributes .= !empty( $params['id'] ) ? ' id="'.$params['id'].'" ' : '' ;
		$ret = '<fieldset '.$attributes.'><legend>'.tra( $params['legend'] ).'</legend>';
		$ret .= $content;
		$ret .= '</fieldset>';
		return $ret;
	}
}
?>
