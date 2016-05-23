<?php
namespace Clickstorm\CsCdn\Controller;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Created by PhpStorm.
 * User: mhirdes
 * Date: 04.05.2016
 * Time: 16:25
 */
class CdnController extends ActionController
{
	public function replaceAction() {
        $cdnOutput = GeneralUtility::makeInstance(\Clickstorm\CsCdn\Utility\CdnUtility::class);
        $cdnOutput->delete(GeneralUtility::_GET('target'));
		$this->redirectToUri(GeneralUtility::_GET('returnUrl'));
	}
}