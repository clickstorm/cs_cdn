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
 * Replaces string in the generated html.
 *
 * @author     Rolel <typo3@smile.fr>
 * @package    TYPO3
 * @subpackage smile_cdn
 */
class StringReplacer {

	/**
	 * @param    tslib_fe    $obj
	 * @return    void    The content is passed by reference
	 */
	function contentPostProc_output(&$params) {

		$obj = &$params['pObj'];

        $fromTo = \Clickstorm\CsCdn\Utility\Basic::buildReplacerFromTo();

        if ($fromTo) {
            // Replace page content
            $obj->content = str_replace($fromTo['from'], $fromTo['to'], $obj->content);

            // Replace additional headers in page
            if (is_array($obj->config['INTincScript_ext']['additionalHeaderData'])) {
                foreach ($obj->config['INTincScript_ext']['additionalHeaderData'] as $key => $value) {
                    $obj->config['INTincScript_ext']['additionalHeaderData'][$key] = str_replace($fromTo['from'], $fromTo['to'], $value);
                }
            }
        }
	}
}

?>