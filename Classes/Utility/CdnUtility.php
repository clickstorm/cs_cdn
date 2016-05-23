<?php
namespace Clickstorm\CsCdn\Utility;

/**
 * Created by PhpStorm.
 * User: lmarschke
 * Date: 09.05.2016
 * Time: 09:00
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

class CdnUtility
{

    /**
     * @var \Clickstorm\CsCdn\Service\KeyCDN
     */
    protected $CdnService;

    /**
     * \TYPO3\CMS\Core\Messaging\FlashMessageService
     */
    protected $flashMessageService;

    protected $zoneId;

    protected $apiKey;

    public function __construct()
    {
        $config = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['cs_cdn']);

        $this->zoneId = $config['zoneId'];
        $this->CdnService = GeneralUtility::makeInstance(\Clickstorm\CsCdn\Service\KeyCDN::class, $config['apiKey']);
        $this->flashMessageService = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
    }

    public function delete($fileUrl)
    {
        $jsonUrl = 'zones/purgeurl/' . $this->zone_id . '.json';

        $error = $this->CdnService->delete($jsonUrl, array(
            'urls' => array($fileUrl),
        ));

        $this->messageOutput($error);
    }

    public function messageOutput($error)
    {
        $messageQueue = $this->flashMessageService->getMessageQueueByIdentifier();
        if($error || is_string($error)) {
            $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                $error,
                'KeyCDN-Error',
                \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR, // the severity is optional as well and defaults to \TYPO3\CMS\Core\Messaging\FlashMessage::OK
                TRUE // optional, whether the message should be stored in the session or only in the \TYPO3\CMS\Core\Messaging\FlashMessageQueue object (default is FALSE)
            );

        } else {
            $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                $_GET['target'],
                'KeyCDN-Success',
                \TYPO3\CMS\Core\Messaging\FlashMessage::OK, // the severity is optional as well and defaults to \TYPO3\CMS\Core\Messaging\FlashMessage::OK
                TRUE // optional, whether the message should be stored in the session or only in the \TYPO3\CMS\Core\Messaging\FlashMessageQueue object (default is FALSE)
            );
        }

        $messageQueue->addMessage($message);
    }

}