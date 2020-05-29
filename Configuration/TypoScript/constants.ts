plugin.tx_slubzotero_zoterobib {
  config {
    css {
      file = EXT:slub_zotero/Resources/Public/Css/zotero.css
    }
    js {
      addJquery = 0
      jqueryLoadingOverlayFile = EXT:slub_zotero/Resources/Public/Js/loadingoverlay.min.js
      zoteroFile = EXT:slub_zotero/Resources/Public/Js/zotero.js
    }
  }
  view {
    # cat=plugin.tx_slubzotero_zoterobib/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:slub_zotero/Resources/Private/Templates/
    # cat=plugin.tx_slubzotero_zoterobib/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:slub_zotero/Resources/Private/Partials/
    # cat=plugin.tx_slubzotero_zoterobib/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:slub_zotero/Resources/Private/Layouts/
  }
}
