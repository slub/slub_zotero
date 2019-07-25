
plugin.tx_slubzotero_zoterobib {
  view {
    templateRootPaths.0 = EXT:slub_zotero/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_slubzotero_zoterobib.view.templateRootPath}
    partialRootPaths.0 = EXT:slub_zotero/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_slubzotero_zoterobib.view.partialRootPath}
    layoutRootPaths.0 = EXT:slub_zotero/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_slubzotero_zoterobib.view.layoutRootPath}
  }
  persistence {
    storagePid = {$plugin.tx_slubzotero_zoterobib.persistence.storagePid}
    #recursive = 1
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}

plugin.tx_slubzotero._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-slub-zotero table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-slub-zotero table th {
        font-weight:bold;
    }

    .tx-slub-zotero table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)
page {
    includeCSS {
        zotero = EXT:slub_zotero/Resources/Public/Css/zotero.css
    }

    includeJSLibs {
        zoterojs = EXT:slub_zotero/Resources/Public/Js/zotero.js
    }
}
