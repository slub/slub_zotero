
plugin.tx_slubzotero_zoterobib {
  view {
    templateRootPaths.0 = EXT:slub_zotero/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_slubzotero_zoterobib.view.templateRootPath}
    partialRootPaths.0 = EXT:slub_zotero/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_slubzotero_zoterobib.view.partialRootPath}
    layoutRootPaths.0 = EXT:slub_zotero/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_slubzotero_zoterobib.view.layoutRootPath}
  }
}

show = PAGE
show {
    typeNum = 99
    config {
        disableAllHeaderCode = 1
        additionalHeaders = Content-type:application/json
        admPanel = 0
        debug = 0
    }

    10 < styles.content.get
    10 {
        stdWrap.trim = 1
        select {
            where = list_type = "slubzotero_zoterobib"
        }

        renderObj < tt_content.list.20.slubzotero_zoterobib
    }
}

page {
    includeCSS {
        zotero = EXT:slub_zotero/Resources/Public/Css/zotero.css
    }

    includeJSFooterlibs {
        # jquery = //code.jquery.com/jquery.js
        # jquery.forceOnTop = 1
        # jquery.external = 1

        jquery_loadingoverlay = EXT:slub_zotero/Resources/Public/Js/loadingoverlay.min.js
        slub_zotero_js = EXT:slub_zotero/Resources/Public/Js/zotero.js
    }
}
