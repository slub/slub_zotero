<?php
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die('Access denied.');

call_user_func(
    static function()
    {
        ExtensionManagementUtility::addStaticFile('slub_zotero', 'Configuration/TypoScript', 'SLUB Zotero');
    }
);
