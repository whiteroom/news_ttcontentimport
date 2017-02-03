<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "news_ttnewsimport"
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Import tt_content to EXT:news',
	'description' => 'Import tt_content elements to news',
	'category' => 'be',
	'author' => 'Georg Ringer',
	'author_email' => 'typo3@ringerge.org',
	'company' => '',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'version' => '6.0.1',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.4-8.99.99',
			'php' => '5.3.0-0.0.0',
			'news' => '3.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);
