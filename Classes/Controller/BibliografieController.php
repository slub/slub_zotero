<?php
namespace Slub\SlubZotero\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\DebugUtility;
/***
 *
 * This file is part of the "SLUB: Zotero Bibliografie" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019
 *
 ***/
/**
 * BibliografieController
 */
class BibliografieController extends ActionController
{
    private $zotero = [];

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction(): void
    {
        $this->settings['debug'] = empty($this->settings['debug']) ? false : true;
        $this->settings['zotero']['format'] = empty($this->settings['zotero']['format']) ? 'json' : $this->settings['zotero']['format'];
        $this->settings['zotero']['locale'] = empty($GLOBALS['TSFE']->config['config']['htmlTag_langKey']) ? 'de-DE' : $GLOBALS['TSFE']->config['config']['htmlTag_langKey'];
        $this->settings['zotero']['linkWrap'] = empty($this->settings['zotero']['linkWrap']) ? 0 : 1;
        $this->settings['zotero']['limit'] = empty($this->settings['zotero']['limit']) ? 100 :  $this->settings['zotero']['limit'];
        $this->settings['zotero']['virtualCollection'] = empty($this->settings['zotero']['virtualCollection']) ? false : true;
        $this->settings['zotero']['titleLink'] = empty($this->settings['zotero']['titleLink']) ? false : true;
        $this->settings['zotero']['ajaxMode'] = empty($this->settings['zotero']['ajaxMode']) ? false : true;

        if ($this->request->hasArgument('collection')) {
            $this->zotero['request']['collection'] =  $this->request->getArgument('collection');
        }
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction(): ResponseInterface
    {
        if (in_array($this->settings['zotero']['action'], ['items','items/top'])) {
            // its a item query
            $collections = $this->getItemsAsCollection();
        } else {
            $collections = $this->getCollections();
        }
        $this->view->assign('collections', $collections);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     *
     * @return void
     */
    public function showAction(): ResponseInterface
    {
        $items = $this->getItems();
        $this->view->assign('items', $items);
        return $this->htmlResponse();
    }

    //url is build with user selected/provided information
    private function buildUrl($action='items') : string
    {
        $url = 'https://api.zotero.org/';
        $url .= $this->settings['zotero']['type'] . '/';
        $url .= $this->settings['zotero']['id'].'/';

        if ($this->settings['zotero']['subCollectionId']) {
            $url .=  'collections/'.$this->settings['zotero']['subCollectionId'].'/';
        }

        $url .= $action . '?';
        $url .= 'format=' . $this->settings['zotero']['format'];
        $url .= '&v=3';
        $url .= '&linkwrap=' . $this->settings['zotero']['linkWrap'];
        $url .= '&locale=' . $this->settings['zotero']['locale'];

        // additional params
        if ($this->settings['zotero']['limit']) {
            $url .= '&limit=' . $this->settings['zotero']['limit'];
        }
        if ($this->settings['zotero']['style']) {
            $url .= '&style=' . $this->settings['zotero']['style'];
        }
        if ($this->settings['zotero']['include']) {
            $url .= '&include=' . $this->settings['zotero']['include'];
        }
        $url .= '&key=' . $this->settings['zotero']['key'];

        if ($this->settings['debug'] == true) {
            DebugUtility::debug($url, 'Debug: ' . __FILE__ . ' in Line: ' . __LINE__ . ' Function: '. __FUNCTION__);
        }
        return $url;
    }



    public function filterCollections(&$collection): void
    {
        $cleanCollection = [];
        foreach ($collection as $collectionKey => $collectionValue) {
            // collection have items
            if ($collectionValue['meta']['numItems'] != 0) {
                $cleanCollection[$collectionKey] = $collectionValue;
                $cleanCollection[$collectionKey]['data']['title'] = $collectionValue['data']['name'];
            }
        }
        $collection = $cleanCollection;
        if ($this->settings['debug'] == true) {
            DebugUtility::debug($cleanCollection, 'Debug: ' . __FILE__ . ' in Line: ' . __LINE__ . ' Function: '. __FUNCTION__);
        }
    }

    // sort the array by any data field
    public function sortDataByDataField(&$data, $dataField='title'): void
    {
        $sortedData = [];

        foreach ($data as $dataKey => $dataValue) {
            $sortField = $dataValue['data'][ $dataField ] .'_'. $dataKey;
            $sortedData[ $sortField ] = $dataValue;
        }

        $this->sortData($sortedData);
        $data = $sortedData;
    }

    public function sortData(&$data): void
    {
        if ($this->settings['zotero']['sorting'] == 'desc') {
            krsort($data);
        } else {
            ksort($data);
        }
        if ($this->settings['debug'] == true) {
            DebugUtility::debug($data, 'Debug: ' . __FILE__ . ' in Line: ' . __LINE__ . ' Function: '. __FUNCTION__);
        }
    }

    // set results from api call to items request
    public function getItemsAsCollection(): array
    {
        if ($this->zotero['request']['collection']) {
            $this->settings['zotero']['subCollectionId'] = $this->zotero['request']['collection'];
        }

        $this->settings['zotero']['include'] = 'bib,data,citation';
        $items = $this->getApiResults($this->settings['zotero']['action']);
        $this->transformItemsToCollection($items);

        if ($this->settings['debug'] == true) {
            DebugUtility::debug($items, 'Debug: ' . __FILE__ . ' in Line: ' . __LINE__ . ' Function: '. __FUNCTION__);
        }
        return $items;
    }

    // set results from api call to items request
    public function getItems(): array
    {
        if ($this->zotero['request']['collection']) {
            $this->settings['zotero']['subCollectionId'] = $this->zotero['request']['collection'];
        }

        $this->settings['zotero']['include'] = 'bib,data,citation';
        $items = $this->getApiResults('items');
        $this->createDataTree($items);

        if ($this->settings['debug'] == true) {
            DebugUtility::debug($items, 'Debug: ' . __FILE__ . ' in Line: ' . __LINE__ . ' Function: '. __FUNCTION__);
        }
        return $items;
    }

    // set results from api call to collections request
    public function getCollections() : array
    {
        $collections = $this->getApiResults('collections');
        $this->filterCollections($collections);
        $this->sortDataByDataField($collections, 'title');

        if ($this->settings['zotero']['ajaxMode'] == false) {
            $items = [];
            foreach ($collections as &$collection) {
                $this->zotero['request']['collection'] = $collection['key'];

                if ($this->settings['zotero']['virtualCollection'] == true) {
                    $items = array_merge($items, $this->getItems());
                } else {
                    $collection['items'] = $this->getItems();
                }
            }

            if ($this->settings['zotero']['virtualCollection'] == true) {
                $this->transformItemsToCollection($items);
                $collections = $items;
            }
        }

        if ($this->settings['debug'] == true) {
            DebugUtility::debug($collections, 'Debug: ' . __FILE__ . ' in Line: ' . __LINE__ . ' Function: '. __FUNCTION__);
        }
        return $collections;
    }

    public function getApiResults($action='items') : array
    {
        $url = $this->buildUrl($action);
        $data = $this->request($url);
        return $data;
    }

    public function request($url, $requestCount=0)
    {
        $json = file_get_contents($url);
        $data = json_decode($json, true);
        $this->reIndexArray($data);

        if ($requestCount==0 && count($data)==$this->settings['zotero']['limit']) {
            // load only one page more
            $url .= '&start='.$this->settings['zotero']['limit'];
            $dataNext = $this->request($url, 1);
            $data = array_merge($data, $dataNext);
        }

        if ($this->settings['debug'] == true) {
            DebugUtility::debug($data, 'Debug: ' . __FILE__ . ' in Line: ' . __LINE__ . ' Function: '. __FUNCTION__);
        }
        return $data;
    }

    public function reIndexArray(&$data)
    {
        $tData = [];
        foreach ($data as $value) {
            $tData[ $value['key'] ] = $value;
        }
        $data = $tData;
    }

    public function createDataTree(&$data, $parentField='parentItem'): void
    {
        $tData = [];
        foreach ($data as $value) {
            if (empty($value['data'][$parentField])) {
                // root item
                if (!isset($tData[ $value['key'] ])) {
                    $tData[ $value['key'] ] = $value;
                    if ($this->settings['zotero']['titleLink'] == true) {
                        $this->linkTitleInBibItems($tData[ $value['key'] ]);
                    }
                }
            } else {
                // child item
                if (isset($tData[ $value['data'][$parentField] ])) {
                    $tData[ $value['data'][$parentField] ]['children'][ $value['key'] ] = $value;
                } else {
                    if (isset($data[ $value['data'][$parentField] ])) {
                        $tData[ $value['data'][$parentField] ] = $data[ $value['data'][$parentField] ];
                        if ($this->settings['zotero']['titleLink'] == true) {
                            $this->linkTitleInBibItems($tData[ $value['data'][$parentField] ]);
                        }
                        $tData[ $value['data'][$parentField] ]['children'][ $value['key'] ] = $value;
                    }
                }
            }
        }
        $data = $tData;
    }

    public function linkTitleInBibItems(&$item): void
    {
        if (!empty($item['data']['url']) && !empty($item['data']['title'])) {
            $link = '<a href="' . $item['data']['url'] . '" target="_blank" class="bib-title-link">' . $item['data']['title'] . '</a>';
            $item['bib'] = str_replace($item['data']['title'], $link, $item['bib']);
        }
    }

    public function transformItemsToCollection(&$items): void
    {
        $this->createDataTree($items);
        $this->sortDataByDataField($items, 'dateAdded');
        $this->buildCollection($items);
    }

    public function buildCollection(&$items): void
    {
        $collection = [];
        foreach ($items as $item) {
            $collectionTitle = substr($item['meta']['parsedDate'], 0, 4);
            $collection[ $collectionTitle ]['data']['title'] = $collectionTitle;
            $collection[ $collectionTitle ]['items'][ $item['key'] ] = $item;
        }

        $this->sortData($collection);
        $items = $collection;
    }
}
