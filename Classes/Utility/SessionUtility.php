<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 23.03.15
 * Time: 14:20
 */

namespace KayStrobach\ThemesShowcase\Utility;

/**
 * Class SessionUtility
 * @package KayStrobach\ThemesShowCase\Utility
 */
class SessionUtility {
	/**
	 * session key for storing the selected skin
	 */
	const SessionKeyForStoringSkin = 'themes_showcase_selected_skin';

	/**
	 * session key for storing the options for the selected skin
	 */
	const SessionKeyForStoringOptions = 'themes_showcase_options';

	/**
	 * @param string $skinName Skin
	 * @return void
	 */
	public static function storeSelectedTheme($skinName) {
		$GLOBALS['TSFE']->fe_user->setKey('ses', self::SessionKeyForStoringSkin, $skinName);
		$GLOBALS['TSFE']->fe_user->sesData_change = true;
		$GLOBALS['TSFE']->fe_user->storeSessionData();
	}

	/**
	 * @return string
	 */
	public static function getSelectedTheme() {
		$data = $GLOBALS['TSFE']->fe_user->getKey('ses', self::SessionKeyForStoringSkin);
		if(!is_string($data)) {
			return NULL;
		}
		return $data;
	}

	/**
	 * @param $options
	 * @return void
	 */
	public function storeOptions($options) {
		$GLOBALS['TSFE']->fe_user->setKey('ses', self::SessionKeyForStoringOptions, $options);
		$GLOBALS['TSFE']->fe_user->sesData_change = true;
		$GLOBALS['TSFE']->fe_user->storeSessionData();
	}

	/**
	 *
	 */
	public function getOptions() {
		$data = $GLOBALS['TSFE']->fe_user->getKey('ses', self::SessionKeyForStoringOptions);
		if(!is_array($data)) {
			return array();
		}
		return $data;
	}
}