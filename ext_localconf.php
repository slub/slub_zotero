<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'SLUB.SlubZotero',
            'Zoterobib',
            [
                'Bibliografie' => 'list, show'
            ],
            // non-cacheable actions
            [

            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    zoterobib {
                        icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Icons/user_plugin_zoterobib.svg
                        title = LLL:EXT:slub_zotero/Resources/Private/Language/locallang_db.xlf:tx_slub_zotero_domain_model_zoterobib
                        description = LLL:EXT:slub_zotero/Resources/Private/Language/locallang_db.xlf:tx_slub_zotero_domain_model_zoterobib.description
                        tt_content_defValues {
                            CType = list
                            list_type = slubzotero_zoterobib
                        }
                    }
                }
                show = *
            }
       }'
    );
    },
    $_EXTKEY
);
