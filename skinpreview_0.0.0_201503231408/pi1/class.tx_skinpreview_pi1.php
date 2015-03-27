<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Jeff Segars <jeff@webempoweredchurch.org>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(t3lib_extMgm::extPath('templavoila_framework') . 'class.tx_templavoilaframework_lib.php');

/**
 * Plugin 'Fronted Skin Preview' for the 'skinpreview' extension.
 *
 * @author	Jeff Segars <jeff@webempoweredchurch.org>
 * @package	TYPO3
 * @subpackage	tx_skinpreview
 */
class tx_skinpreview_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_skinpreview_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_skinpreview_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'skinpreview';	// The extension key.
	var $pi_USER_INT_obj = TRUE;
	/**
	 * @var array
	 */
	protected $skinInfos = array();

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf)	{
			// Yes, this is evil but we do it for a reason here. Since skins change frequently, never cache a page.
		$GLOBALS['TSFE']->set_no_cache();

		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_initPIflexForm();
		$this->conf = $conf;

				// Avoid double inclusions
		if (!$GLOBALS['skinSelectorProcessed']) {
			$GLOBALS['skinSelectorProcessed'] = TRUE;
			return $this->drawSkinSelector();
		}
	}

	protected function drawSkinSelector() {
		$this->initSkinArray();
		$templateFile = t3lib_div::getFileAbsFileName('EXT:skinpreview/Resources/Private/Template/SkinPreview.html');
		$view = t3lib_div::makeInstance('Tx_Fluid_View_StandaloneView');
		$view->setTemplatePathAndFilename($templateFile);
		$view->assign('skins'             , $this->skinInfos);
		$view->assign('TYPO3_REQUEST_URL' , t3lib_div::getIndpEnv('TYPO3_REQUEST_URL'));
		$view->assign('time'              , date('d.m.Y H:i:s'));
		$view->assign('skinpreviewAllowed', tx_skinpreview_assignSkin::inRootLineOfAllowedPid());
		$view->assign('currentSkin'       , $this->getCurrentSkinKey());
		return $view->render();
	}

	protected function initSkinArray() {
		$currentSkinKey = $this->getCurrentSkinKey();

		$skinKeys = tx_templavoilaframework_lib::getSkinKeys();
		natsort($skinKeys);
		$this->skinInfos = array();

		$this->deniedSkins = t3lib_div::trimExplode(',', $this->conf['settings.']['skinsToHide'], TRUE);

		foreach($skinKeys as $idx => $skinKey) {
			if(in_array($skinKey, $this->deniedSkins)) {
				#unset($skinKey[$idx]);
			} else {
				$skinInfo = tx_templavoilaframework_lib::getSkinInfo($skinKey);
				$skinInfo['key'] = $skinKey;
				if ($skinKey === $currentSkinKey) {
					$skinInfo['selected'] = true;
				} else {
					$skinInfo['selected'] = false;
				}
				$this->skinInfos[] = $skinInfo;
			}
		}
	}
	/**
	 * @todo needs to support custom skins as well, currently only EXT: skins are supported!
	 *
	 * @return retrieve current skin from template
	 */
	protected function getCurrentSkinKey() {
		$skinPath = explode('/', $GLOBALS['TSFE']->tmpl->flatSetup['templavoila_framework.skinPath']);
		return 'EXT:'.$skinPath[count($skinPath)-2];
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/skinpreview/pi1/class.tx_skinpreview_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/skinpreview/pi1/class.tx_skinpreview_pi1.php']);
}

?>
