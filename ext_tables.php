<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'SLUB.SlubZotero',
            'Zoterobib',
            'SLUB Zotero Bibliografie Plugin'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'SLUB Bibliografie');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_slubzotero_domain_model_bibliografie', 'EXT:slub_zotero/Resources/Private/Language/locallang_csh_tx_slubzotero_domain_model_bibliografie.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_slubzotero_domain_model_bibliografie');

    },
    $_EXTKEY
);
