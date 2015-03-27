<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 23.03.15
 * Time: 14:22
 */

namespace KayStrobach\ThemesShowcase\Utility;


use TYPO3\CMS\Core\Utility\GeneralUtility;

class PermissionUtility {
	public static function inRootLineOfAllowedPid() {
		$config            = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['themes_showcase']);
		$allowedRootPages  = GeneralUtility::trimExplode(',', $config['allowedRootPages']);
		foreach($GLOBALS['TSFE']->rootLine as $page) {
			if(in_array($page['uid'], $allowedRootPages)) {
				return true;
			}
		}
		return false;
	}
}