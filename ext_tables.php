<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


\GeorgRinger\News\Utility\ImportJob::register(
	'GeorgRinger\\NewsTtcontentimport\\Jobs\\TtContentImportJob',
	'LLL:EXT:news_ttcontentimport/Resources/Private/Language/locallang_be.xml:ttcontent_importer_title',
	'');
