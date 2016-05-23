<?php
namespace Clickstorm\CsCdn\Hooks;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Created by PhpStorm.
 * User: lmarschke
 * Date: 04.05.2016
 * Time: 10:04
 */
class IconHook implements \TYPO3\CMS\Filelist\FileListEditIconHookInterface {

    /**
     * Modifies edit icon array
     *
     * @param array $cells Array of edit icons
     * @param \TYPO3\CMS\Filelist\FileList $parentObject Parent object
     * @return void
     */
    public function manipulateEditIcons(&$cells, &$parentObject)
    {
        /** @var \TYPO3\CMS\Core\Resource\File $file */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $fullIdentifier = $cells['__fileOrFolderObject']->getPublicUrl();
        if ($cells['__fileOrFolderObject'] instanceof \TYPO3\CMS\Core\Resource\File) {
            $url = BackendUtility::getModuleUrl('file_CsCdnCdn', array('target' => $fullIdentifier));
            $renameOnClick = 'top.content.list_frame.location.href = ' . GeneralUtility::quoteJSvalue($url) . '+\'&returnUrl=\'+top.rawurlencode(top.content.list_frame.document.location.pathname+top.content.list_frame.document.location.search);return false;';
            $cells['cdn'] = '<a href="#" class="btn btn-default" onclick="' . htmlspecialchars($renameOnClick) . '"  title="CDN"> ' . $iconFactory->getIcon('tx-cscdn-replace', Icon::SIZE_SMALL)->render() . '</a>';
        }
    }
}