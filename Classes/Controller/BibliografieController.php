<?php
namespace SLUB\SlubZotero\Controller;

/***
 *
 * This file is part of the "SLUB Zotero Bibliografie" Extension for TYPO3 CMS.
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
class BibliografieController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $headline = $this->settings['zotero']['headline'];
        $urlToCall = $this->buildUrl();
        $collection = $this->callParentCollection($urlToCall);
        $secondRun = $this->getSubCollection($collection);
        $sortedList = $this->sortCollection($secondRun);



        $this->view->assign('presentation', $sortedList);
        $this->view->assign('headline', $headline);

    }

    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {
        $headline = $this->settings['zotero']['headline'];
        $yearKey = $this->request->getArgument('collection');
        var_dump($yearKey);
        $arrayForPresentation = $this->callSubCollections($this->request->getArgument('collection'));
        var_dump($this->request->getArgument('collection'));


        $this->view->assign('headline', $headline);
        $this->view->assign('yearKey', $yearKey);
        $this->view->assign('subCollection', $arrayForPresentation);
    }

    //url is build with user selected/provided informations
    function buildUrl()
    {
        $subCollections = '';

        if($this->settings['zotero']['selection'] == 'users')
        {
            $begin = 'https://api.zotero.org/users/';
        }else
        {
            $begin = 'https://api.zotero.org/groups/';
        }

        $userOrGroupID = $this->settings['zotero']['id'].'/';

        if($this->settings['zotero']['subCollection'])
        {
            $subCollections = 'collections/'.$this->settings['zotero']['subCollectionID'].'/collections?';
        }

        $format = 'format='.'json';

        $limit = '&limit='.'10';

        $key = '&key='.$this->settings['zotero']['key'];

        $url = $begin.$userOrGroupID.$subCollections.$format.$key;

        return $url;
    }

    //api call of a collection in a group
    function callParentCollection($url)
    {

        $apiAnswer = file_get_contents($url);


        $apiAnswerDecode = json_decode($apiAnswer, true);
        return $apiAnswerDecode;
    }

    //callParentCollection provides infos about its subcollections like name, key if its empty or not, here a helper array is created with the needed keys and the year
    function getSubCollection($apiAnswerDecode)
    {
        $i = 0;
        //~ var_dump($apiAnswerDecode);
        foreach($apiAnswerDecode as $apiAnswerDecodeKey => $apiAnswerDecodeValue)
        {
            if($apiAnswerDecode[$i]['meta']['numItems'] != 0 || $apiAnswerDecode[$i]['meta']['numCollections'] != 0)
            {
                $wanted[$i]['key'] = $apiAnswerDecode[$i]['key'];
                $wanted[$i]['year'] = substr($apiAnswerDecode[$i]['data']['name'], -4, 4);
            }
            $i++;
        }
        return $wanted;
    }

    //api needs to be called again to get the actual items of the subcollections, needs to be called a third time because parameters don't work as suggested
    function callSubCollections($subArray)
    {
        $i = 0;
        $final =array();
        $subCollections = '';

        if($this->settings['zotero']['selection'] == 'users')
        {
            $begin = 'https://api.zotero.org/users/';
        }else
        {
            $begin = 'https://api.zotero.org/groups/';
        }

        $userOrGroupID = $this->settings['zotero']['id'].'/collections/';

        foreach($subArray as $subArrayKey => $subArrayValue)
        {
            $apiAnswer = file_get_contents($begin.$userOrGroupID.$subArrayValue['key'].'/items?format=json&key='.$this->settings['zotero']['key']);
            //"&include=citation" doesn't work as wanted, so api needs to be called again with diff parameters

            $apiAnswerCitationWanted = file_get_contents($begin.$userOrGroupID.$subArrayValue['key'].'/items?format=json&include=citation&style='.$this->settings['zotero']['style'].'&key='.$this->settings['zotero']['key']);

            $subCollectionItems = json_decode ($apiAnswer, true);
            $subCollectionItemsCitationWanted = json_decode ($apiAnswerCitationWanted, true);


            foreach($subCollectionItems as $subCollectionItemsKey => $subCollectionItemsValue)
            {
                $final[$i][$subCollectionItemsKey] = $subCollectionItemsValue;
            }
            //second call is handled and citation is added to a combined array
            foreach($subCollectionItemsCitationWanted as $subCollectionItemsCitationWantedKey => $subCollectionItemsCitationWantedValue)
            {
                $final[$i][$subCollectionItemsCitationWantedKey]['citation'] = $subCollectionItemsCitationWantedValue['citation'];
            }
            $year = $subArrayValue['year'];
            $final[$year] = $final[$i];
            unset($final[$i]);

            $i++;
        }

        //own handling because "&sort=date&direction=desc" doesn't work
        if($this->settings['zotero']['sorting'] == 'desc')
        {
            krsort($final);
        }
        else
        {
            ksort($final);
        }
        return $final;
    }

}
