<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

/* Default TS */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'CDN Config');

if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Clickstorm.CsCdn',
		'file',
		'cdn',
		'',
		array(
			'Cdn' => 'replace',
		),
		array(
			'access' => 'user,group',
			'workspaces' => 'online,custom',
			'icon' => 'EXT:filelist/Resources/Public/Icons/module-filelist.svg',
			'labels' => 'LLL:EXT:lang/locallang_mod_file_list.xlf'
		)
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('options.hideModules.file := addToList(CsCdnCdn)');
?>