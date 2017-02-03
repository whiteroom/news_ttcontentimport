<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Import tt_content to EXT:news',
    'description' => 'Import tt_content elements to news',
    'category' => 'fe',
    'author' => 'Georg Ringer',
    'author_email' => 'typo3@ringerge.org',
    'shy' => '',
    'dependencies' => '',
    'conflicts' => '',
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => 1,
    'modify_tables' => '',
    'clearCacheOnLoad' => 1,
    'lockType' => '',
    'author_company' => '',
    'version' => '6.0.0',
    'constraints' => [
        'depends' => [
            'news' => '5.3-6.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'suggests' => [],
];
