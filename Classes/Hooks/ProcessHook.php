<?php
namespace Clickstorm\CsCdn\Hooks;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Created by PhpStorm.
 * User: lmarschke
 * Date: 02.05.2016
 * Time: 13:14
 */

class ProcessHook implements \TYPO3\CMS\Core\Utility\File\ExtendedFileUtilityProcessDataHookInterface {

    /**
     * Post-process a file action.
     *
     * @param string $action The action
     * @param array $cmdArr The parameter sent to the action handler
     * @param array $result The results of all calls to the action handler
     * @param \TYPO3\CMS\Core\Utility\File\ExtendedFileUtility $parentObject Parent object
     * @return void
     */
    public function processData_postProcessAction($action, array $cmdArr, array $result, \TYPO3\CMS\Core\Utility\File\ExtendedFileUtility $parentObject)
    {
        $cdnOutput = GeneralUtility::makeInstance(\Clickstorm\CsCdn\Utility\CdnUtility::class);

        /** @var \TYPO3\CMS\Core\Resource\File $file */
        foreach($result as $entry) {
            if(is_array($entry)) {
                foreach($entry as $file) {
                    $cdnOutput->delete($file->getPublicUrl());
                }
            }
        }
    }
}