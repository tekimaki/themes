<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * required setup
 */
global $gBitSmarty;
require_once $gBitSmarty->_get_plugin_filepath( 'modifier', 'bit_date_format' );

/**
 * smarty_modifier_bit_short_time
 */
function smarty_modifier_bit_short_time( $pString ) {
	global $gBitSystem;
	return smarty_modifier_bit_date_format( $pString, $gBitSystem->get_short_time_format(), '%H:%M %Z' );
}
?>
