<?php
namespace Clickstorm\CsCdn\Utility;
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Rolel <typo3@smile.fr>
*  (c) 2015 Hirdes <hirdes@clickstorm.de>
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
 * Change generated images path
 *
 * @author     Hirdes <hirdes@clickstorm.de>
 * @package    TYPO3
 * @subpackage cs_cdn
 */
class TslibCobj extends \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer {

	/**
	 * Rendering the cObject, IMG_RESOURCE
	 *
	 * @param	array		Array of TypoScript properties
	 * @return	string		Output
	 * @link http://typo3.org/doc.0.html?&tx_extrepmgm_pi1[extUid]=270&tx_extrepmgm_pi1[tocEl]=354&cHash=46f9299706
	 * @see getImgResource()
	 */
	function IMG_RESOURCE($conf)    {
		$original = parent::IMG_RESOURCE($conf);

		$url = Basic::getImgUrl($original);
		$cdn = Basic::getCDN();

		$original = str_replace($url, $cdn.$url, $original);

		return $original;
	}

	/**
	 * Returns a <img> tag with the image file defined by $file and processed according to the properties in the TypoScript array.
	 * Mostly this function is a sub-function to the IMAGE function which renders the IMAGE cObject in TypoScript. This function is called by "$this->cImage($conf['file'],$conf);" from IMAGE().
	 *
	 * @param	string		File TypoScript resource
	 * @param	array		TypoScript configuration properties
	 * @return	string		<img> tag, (possibly wrapped in links and other HTML) if any image found.
	 * @access private
	 * @see IMAGE()
	 */
	function cImage($file,$conf) {
		$original = parent::cImage($file,$conf);

		$url = Basic::getImgUrl($original);
		$cdn = Basic::getCDN();

		$original = str_replace($url, $cdn.$url, $original);

		return $original;
	}

}



?>