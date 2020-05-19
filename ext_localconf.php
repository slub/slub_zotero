<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Slub.SlubZotero',
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
                            icon = EXT:slub_zotero/Resources/Public/Icons/user_plugin_zoterobib.svg
                            title = LLL:EXT:slub_zotero/Resources/Private/Language/Backend.xlf:wizard.title
                            description = LLL:EXT:slub_zotero/Resources/Private/Language/Backend.xlf:wizard.description
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
        print_r( \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) );
    },
    $_EXTKEY
);
