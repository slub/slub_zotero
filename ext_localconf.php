<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    static function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Slub.SlubZotero',
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
            'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        zoterobib {
                            iconIdentifier = user_plugin_zoterobib
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

        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

        $iconRegistry->registerIcon(
            'user_plugin_zoterobib',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:slub_zotero/Resources/Public/Icons/user_plugin_zoterobib.svg']
        );
    }
);
