<?php
namespace Clickstorm\CsCdn\Utility;

/**
 * Created by PhpStorm.
 * User: lmarschke
 * Date: 09.05.2016
 * Time: 09:00
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

class ExtensionSettings
{
    public static function get()
    {
        if(TYPO3_MODE === 'BE') {
            $configurationManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager::class);
            $tsSetup = $configurationManager->getTypoScriptSetup();
        } else {
            $tsSetup = $GLOBALS['TSFE']->tmpl->setup;
        }
        return $tsSetup['plugin.']['tx_cscdn.']['settings.'];
    }


}