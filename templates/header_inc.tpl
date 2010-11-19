{* $Header$ *}
{strip}
{* CSS *}
{foreach from=$gBitThemes->mRawFiles.css item=cssFile}
	<link rel="stylesheet" title="{$style}" type="text/css" href="{$cssFile}" media="all" />
{/foreach}
{if $gBitThemes->mStyles.joined_css}
	<link rel="stylesheet" title="{$style}" type="text/css" href="{$gBitThemes->mStyles.joined_css}" media="all" />
{/if}
{/strip}

{* JAVASCRIPT *}
<script type="text/javascript">/* <![CDATA[ */
	BitSystem = {ldelim}
{strip}
		"urls":{ldelim}
		{foreach from=$gBitSystem->mPackagesConfig item=pkgInfo key=pkg}
			{if $gBitSystem->isPackageActive( $pkg )}
				"{$pkg}":"{$pkgInfo.url}",
			{/if}
		{/foreach}
		{foreach from=$gBitSystem->mPackagePluginsConfig item=pluginInfo key=plugin}
			{if $gBitSystem->isPluginActive( $plugin )}
				"{$pluginInfo.package_guid}_{$plugin}":"{$gBitSystem->getPackagePluginUrl($pluginInfo)}",
			{/if}
		{/foreach}
			"root":"{$smarty.const.BIT_ROOT_URL}",
			"cookie":"{$smarty.const.BIT_ROOT_URL}",
			"iconstyle":"{$smarty.const.THEMES_PKG_URL}icon_styles/{$smarty.const.DEFAULT_ICON_STYLE}/"
		{rdelim}
{/strip}
	{rdelim};
	var bitCookiePath = "{$smarty.const.BIT_ROOT_URL}";
	var bitCookieDomain = "";
	var bitIconDir = "{$smarty.const.LIBERTY_PKG_URL}icons/";
	var bitRootUrl = "{$smarty.const.BIT_ROOT_URL}";
	var bitTk = "{$gBitUser->mTicket}";
/* ]]> */</script>

{if $gBitThemes->mStyles.joined_javascript}
	<script type="text/javascript" src="{$gBitThemes->mStyles.joined_javascript}"></script>
{/if}
{foreach from=$gBitThemes->mRawFiles.js item=jsFile}
	<script type="text/javascript" src="{$jsFile}"></script>
{/foreach}

{* @TODO move this to a method in theme where it can load such admin opt in driven js libraries as part of the packing process *}
{if $gBitSystem->isFeatureActive( 'site_use_jscalendar' )}
	<link rel="stylesheet" title="{$style}" type="text/css" href="{$smarty.const.UTIL_PKG_URL}javascript/libs/dynarch/jscalendar/calendar-bitweaver.css" media="all" />
	<script type="text/javascript" src="{$smarty.const.UTIL_PKG_URL}javascript/libs/dynarch/jscalendar/calendar.js"></script>
	<script type="text/javascript" src="{$smarty.const.UTIL_PKG_URL}javascript/libs/dynarch/jscalendar/lang/calendar-en.js"></script>
	<script type="text/javascript" src="{$smarty.const.UTIL_PKG_URL}javascript/libs/dynarch/jscalendar/calendar-setup.js"></script>
{/if}

{if $gBrowserInfo.browser eq 'ie' && $gBitSystem->getConfig('themes_use_msie_js_fix') && $gBrowserInfo.maj_ver lt '8'}
		<script type="text/javascript" src="{$smarty.const.UTIL_PKG_URL}javascript/fixes/ie7/IE{$gBitSystem->getConfig('themes_use_msie_js_fix')}.js"></script>
{/if}
