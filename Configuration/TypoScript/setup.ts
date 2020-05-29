
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

# add required css
page.includeCSS {
  zotero = {$plugin.tx_slubzotero_zoterobib.config.css.file}
}

# add jquery js
[{$plugin.tx_slubzotero_zoterobib.config.js.addJquery} == 1]
  page.includeJSFooterlibs.jquery = //code.jquery.com/jquery.js
  page.includeJSFooterlibs.jquery {
    jquery.forceOnTop = 1
    jquery.external = 1
  }
[global]

# add required js
page.includeJSFooterlibs {
  jqueryLoadingOverlay = {$plugin.tx_slubzotero_zoterobib.config.js.jqueryLoadingOverlayFile}
  zotero = {$plugin.tx_slubzotero_zoterobib.config.js.zoteroFile}
}


# ajax call
show = PAGE
show {
  typeNum = 6452187564
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
