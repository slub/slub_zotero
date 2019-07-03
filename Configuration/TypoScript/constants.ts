
plugin.tx_slubzotero_zoterobib {
  view {
    # cat=plugin.tx_slubzotero_zoterobib/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:slub_zotero/Resources/Private/Templates/
    # cat=plugin.tx_slubzotero_zoterobib/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:slub_zotero/Resources/Private/Partials/
    # cat=plugin.tx_slubzotero_zoterobib/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:slub_zotero/Resources/Private/Layouts/
  }
  persistence {
    # cat=plugin.tx_slubzotero_zoterobib//a; type=string; label=Default storage PID
    storagePid =
  }
}
