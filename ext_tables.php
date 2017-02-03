<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\GeorgRinger\News\Utility\ImportJob::register(
	'BeechIt\\NewsTtnewsimport\\Jobs\\TTNewsNewsImportJob',
	'LLL:EXT:news_ttnewsimport/Resources/Private/Language/locallang_be.xml:ttnews_importer_title',
	'');
