<?php

class tx_skinpreview_assignSkin {
	public function main($params) {
		$skinKey = $params['skinKey'];
		if (TYPO3_MODE === 'FE' and self::inRootLineOfAllowedPid()) {
			// Yes, this is evil but we do it for a reason here. Since skins change frequently, never cache a page.
			$GLOBALS['TSFE']->set_no_cache();
		
			if (t3lib_div::_GP('skinSelector')) {
				$this->storeInSession(t3lib_div::_GP('skinSelector'));
			}

			$userSkinKey = $this->retrieveFromSession();
			if ($userSkinKey) {
				return $userSkinKey;
			}
		}
		return $skinKey;
	}

	protected function storeInSession($skinKey) {
		$GLOBALS["TSFE"]->fe_user->setKey("ses","tx_skinpreview_pi1", $skinKey);
		$GLOBALS["TSFE"]->fe_user->sesData_change = true;
		$GLOBALS["TSFE"]->fe_user->storeSessionData();		
	}
	
	/*
	 * Retrieves session data.
	 * @return		array		The array of session data for the extension.
	 */
	protected function retrieveFromSession() {
		return $GLOBALS["TSFE"]->fe_user->getKey("ses","tx_skinpreview_pi1");
	}

	public static function inRootLineOfAllowedPid() {
		$config            = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['skinpreview']);
		$allowedRootPages  = t3lib_div::trimExplode(',', $config['allowedRootPages']);
		foreach($GLOBALS['TSFE']->rootLine as $page) {
			if(in_array($page['uid'], $allowedRootPages)) {
				return true;
			}
		}
		return false;
	}
}

?>