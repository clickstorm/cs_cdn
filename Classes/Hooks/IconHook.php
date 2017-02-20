<?php
namespace Clickstorm\CsCdn\Hooks;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Filelist\FileList;

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
        $fullIdentifier = $cells['__fileOrFolderObject']->getPublicUrl();
        $version = \TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version();
        if ($cells['__fileOrFolderObject'] instanceof \TYPO3\CMS\Core\Resource\File) {
            $url = BackendUtility::getModuleUrl('file_CsCdnCdn', array('target' => $fullIdentifier));
            $renameOnClick = 'top.content.list_frame.location.href = ' . GeneralUtility::quoteJSvalue($url) . '+\'&returnUrl=\'+top.rawurlencode(top.content.list_frame.document.location.pathname+top.content.list_frame.document.location.search);return false;';
            if($version > 7){
                $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
                $cells['cdn'] = '<a href="#" class="btn btn-default" onclick="' . htmlspecialchars($renameOnClick) . '"  title="CDN"> ' . $iconFactory->getIcon('tx-cscdn-replace', Icon::SIZE_SMALL)->render() . '</a>';
            } else {
                $cells['cdn'] = '<a href="#" class="btn btn-default" onclick="' . htmlspecialchars($renameOnClick) . '"  title="CDN">
                    <span class="t3js-icon icon icon-size-small icon-state-default icon-tx-cscdn-replace" data-identifier="tx-cscdn-replace">
                        <span class="icon-markup">
                            <img src="/typo3conf/ext/cs_cdn/Resources/Public/Icons/replace.png" width="16" height="16">
                        </span>
                    </span>
                </a>';
            }
        }
    }
}
