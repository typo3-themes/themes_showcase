<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 23.03.15
 * Time: 15:15
 */

namespace KayStrobach\ThemesShowcase\Hook;


use KayStrobach\ThemesShowcase\Utility\PermissionUtility;
use KayStrobach\ThemesShowcase\Utility\SessionUtility;
use TYPO3\CMS\Core\FormProtection\Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class OverwriteThemeHook {
	public function main(&$params, &$pObj) {
		if (TYPO3_MODE === 'FE' and PermissionUtility::inRootLineOfAllowedPid()) {
			// Yes, this is evil but we do it for a reason here. Since skins change frequently, never cache a page.
			$GLOBALS['TSFE']->set_no_cache();

			return SessionUtility::getSelectedTheme();
		}
	}
}