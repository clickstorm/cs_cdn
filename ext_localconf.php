<?php

if (!defined ('TYPO3_MODE'))     die ('Access denied.');

if(TYPO3_MODE=='FE') {
	$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);

    // hook is called after Caching / pages with COA_/USER_INT objects.
    $TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'Clickstorm\\CsCdn\\Utility\\StringReplacer->contentPostProc_output';

    // hook is called before Caching / pages on their way in the cache.
    $TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = 'Clickstorm\\CsCdn\\Utility\\StringReplacer->contentPostProc_output';
//    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'Clickstorm\\CsCdn\\Utility\\StringReplacer->contentPostProc_output';

	// namespace TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
	$TYPO3_CONF_VARS['FE']['XCLASS']['tslib/class.tslib_content.php'] = 'Clickstorm\\CsCdn\\Utility\\TslibCobj';

}

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer'] = array(
		'className' => 'Clickstorm\\CsCdn\\Utility\\TslibCobj'
);

$config = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['cs_cdn']);

// if uploadHook is activated, Hook to ProcessHook to delete all URLs
if ($config['uploadHook']){
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_extfilefunc.php']['processData']['cs_cdn'] = 'Clickstorm\\CsCdn\\Hooks\\ProcessHook';
}

// if iconHook is activated, add a new button to the options which deletes CDN cache
if ($config['iconHook']){
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['fileList']['editIconsHook']['cs_cdn'] = 'EXT:cs_cdn/Classes/Hooks/IconHook.php:Clickstorm\\CsCdn\\Hooks\\IconHook';

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Imaging\IconRegistry::class
    );

    $iconRegistry->registerIcon(
        'tx-cscdn-replace', // Icon-Identifier, z.B. tx-myext-action-preview
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        ['source' => 'EXT:cs_cdn/Resources/Public/Icons/replace.png']
    );
}


?>