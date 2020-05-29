<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

      \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
          'Slub.SlubZotero',
          'Zoterobib',
          'SLUB: Zotero Bibliografie'
      );

      $pluginSignature = 'slubzotero_zoterobib';
      $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
      \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignature,
        'FILE:EXT:slub_zotero/Configuration/FlexForms/Slub_Zotero.xml'
      );

    },
    'slub_zotero'
);
