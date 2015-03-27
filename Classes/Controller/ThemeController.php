<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 23.03.15
 * Time: 14:26
 */

namespace KayStrobach\ThemesShowcase\Controller;


use KayStrobach\ThemesShowcase\Utility\SessionUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ThemeController extends ActionController{
	/**
	 * @inject
	 * @var \KayStrobach\Themes\Domain\Repository\ThemeRepository
	 */
	protected $themeRepository = NULL;

	/**
	 *
	 */
	public function showAction() {
		$this->view->assign('themes', $this->themeRepository->findAll());
		$this->view->assign('selectedTheme', $this->themeRepository->findByUid(SessionUtility::getSelectedTheme()));
	}

	/**
	 * @param string $themeName
	 */
	public function selectAction($themeName) {
		SessionUtility::storeSelectedTheme($themeName);
		$this->redirect('show');
	}

	/**
	 * @param array $options
	 */
	public function setOptionsActions($options) {

	}
}