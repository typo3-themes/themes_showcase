<?php


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'KayStrobach.' . $_EXTKEY,
	'ThemesShowcase', array(
		'Theme' => 'show, select, setOptions'
	),
	array()
);


$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/themes/Classes/Hook/T3libTstemplateIncludeStaticTypoScriptSourcesAtEndHook.php']['setTheme'][]
	= 'KayStrobach\ThemesShowcase\Hook\OverwriteThemeHook->main';