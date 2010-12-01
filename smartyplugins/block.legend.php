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
		$params['class'] = !empty( $params['class'] )?$params['class'].' ':' ';
	}
	if( $content ) {
		$attributes = ' class="';
		$attributes .= !empty( $params['layout'] )?$params['layout'].' ':' inlineLabels ';
		$attributes .= !empty( $params['class'] ) ?$params['class'].' ' : '' ;
		$attributes .= '" ';
		$attributes .= !empty( $params['id'] ) ? ' id="'.$params['id'].'" ' : '' ;
		$legendAttributes .= !empty( $params['legendclass'] ) ? ' '.$params['legendclass'].' ' : '' ;
		$ret = '<fieldset '.$attributes.'><div class="legend '.$legendAttributes.'">'.tra( $params['legend'] ).'</div>';
		$ret .= $content;
		$ret .= '</fieldset>';
		return $ret;
	}
}
?>
