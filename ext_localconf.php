<?php
defined('TYPO3') || die('Access denied.');

call_user_func(
    static function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'SlubZotero',
            'Zoterobib',
            [
                \Slub\SlubZotero\Controller\BibliografieController::class => 'list, show'
            ],
            // non-cacheable actions
            [

            ]
        );

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '@import "EXT:slub_zotero/Configuration/TsConfig/ContentElementWizard.tsconfig"'
        );
    }
);
