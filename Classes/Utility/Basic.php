<?php
namespace Clickstorm\CsCdn\Utility;
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Rolel <typo3@smile.fr>
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
 * Useful methods
 *
 * @author     Rolel <typo3@smile.fr>
 * @author     Hirdes <hirdes@clickstorm.de>
 * @package    TYPO3
 * @subpackage smile_cdn
 */
class Basic {

	/**
 	 * Search for the url inside an html string
	 *
	 * @param    string		$text: String containing url as html or raw url
	 * @return   string     The img url
	 */
    public static function getImgUrl($text) {
        $url = $text;
        $config = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_cscdn.']['settings.'];

        if ($config['enable']) {
            $matchStrings = array(
                '/href=\"(.*)\"/iU',
                '/src=\"(.*)\"/iU'
            );

            foreach($matchStrings as $matchStr) {
                preg_match($matchStr, $text, $matches);
                if (is_array($matches) && count($matches) > 0) {
                    $url = $matches[1];
                    continue;
                }
            }
        }

		return $url;
	}


	/**
 	 * Build the From and to array for strreplace
	 *
	 * @param    string		$text: String containing url as html or raw url
	 * @return   string     The img url
	 */
    public static function buildReplacerFromTo() {
        $config = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_cscdn.']['settings.'];

        if ($config['enable']) {
            $fromTo = array(
                'from' => array(),
                'to' => array(),
            );

            // Get a random CDN host
            $randomCdn = Basic::getCdn($config);

            if (!empty($randomCdn)) {
                foreach($config['filters.'] as $key => $filter) {
                    $from = $filter['replace'];
                    $to = $filter['to'];
                    if (!empty($from) && !empty($to)) {

                        if(empty($filter['cdn'])) {
                            $cdn = $randomCdn;
                        } else {
                            $cdn = '//' .$config['cdn.'][$filter['cdn']] . '/';
                        }

                        $from = $cdn . $from . '/';

                        $fromTo['from'][] = '"/'.$to.'/';
                        $fromTo['from'][] = '"'.$to.'/';
                        $fromTo['from'][] = ', /'.$to.'/';
                        $fromTo['from'][] = ', '.$to.'/';
                        $fromTo['from'][] = '(\'/'.$to.'/';
                        $fromTo['from'][] = '("/'.$to.'/';
                        $fromTo['from'][] = '(\''.$to.'/';
                        $fromTo['from'][] = '("'.$to.'/';

                        $fromTo['to'][] = '"' . $from ;
                        $fromTo['to'][] = '"' . $from;
                        $fromTo['to'][] = ', ' . $from;
                        $fromTo['to'][] = ', ' . $from;
                        $fromTo['to'][] = '(\'' . $from;
                        $fromTo['to'][] = '("' . $from;
                        $fromTo['to'][] = '(\'' . $from;
                        $fromTo['to'][] = '("' . $from;

                    }
                }
            }

            return $fromTo;
        } else {
            return false;
        }
	}


	/**
 	 * Return a random CDN
	 *
	 * @param	array		The unserialized config
	 *
	 * @return   string     The cdn host
	 */
    public static function getCDN($config = null) {

		if (is_null($config) ) {
			$config = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_cscdn.']['settings.'];
		}

        if ($config['enable']) {
            $cdnHostArray = array();

            if(isset($config['cdn.']) && is_array($config['cdn.'])) {
                foreach($config['cdn.'] as $key => $val) {
                    $cdnHostArray[] = trim($val);
                }
            }

            // Return one CDN
            $cdn = '//' . $cdnHostArray[array_rand($cdnHostArray)] . '/';

            return $cdn;
        } else {
            return false;
        }
	}


}

//if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/smile_cdn/class.tx_smilecdn_cdn.php'])    {
//	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/smile_cdn/class.tx_smilecdn_cdn.php']);
//}

?>