<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "cs_cdn".
 *
 * Auto generated 17-04-2015 09:04
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => '[clickstorm] Content Delivery Network',
	'description' => 'CDN Extension which manipulate resources path to load them from CDN.',
	'category' => 'plugin',
	'version' => '1.1.0',
	'state' => 'stable',
	'uploadfolder' => false,
	'createDirs' => '',
	'clearcacheonload' => true,
	'author' => 'Lennart Marschke, Marc Hirdes - Clickstorm GmbH',
	'author_email' => 'hirdes@clickstorm.de',
	'author_company' => 'clickstorm GmbH',
	'constraints' => 
	array (
		'depends' => 
		array (
			'typo3' => '6.2.0-7.6.99',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);

