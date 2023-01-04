 <?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    static function()
    {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('slub_zotero', 'Configuration/TypoScript', 'SLUB Zotero');
    }
);
