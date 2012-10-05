<?php

/**
 * Copyright (c) 2012, ROQUIN B.V. (C), http://www.roquin.nl
 *
 * @author:         Jochem de Groot <jochem@roquin.nl>
 * @file:           EventLinkViewHelper.php
 * @description:    ViewHelper to render proper links for event detail view
 */

class Tx_RoqNewsevent_ViewHelpers_LinkViewHelper extends Tx_News_ViewHelpers_LinkViewHelper {
    const NEWS_TYPE_DEFAULT         = 0;
   	const NEWS_TYPE_URL_INTERNAL    = 1;
   	const NEWS_TYPE_URL_EXTERNAL    = 2;

    /**
     * Render link to news item or internal/external pages
     *
     * @param Tx_News_Domain_Model_News $newsItem
     * @param array $settings
     * @param boolean $hsc add htmlspecialchars() at the end
     * @param array $configuration optional typolink configuration
     * @param string $action optional typolink additional action
     * @return string url
     */
    public function render(Tx_News_Domain_Model_News $newsItem, array $settings = array(), $hsc = FALSE, $configuration = array(), $action = NULL) {
        // modify link action, so that the event detail action will be used (only for default news records)
        if($newsItem->getType() == Tx_RoqNewsevent_ViewHelpers_LinkViewHelper::NEWS_TYPE_DEFAULT) {
            if($action !== NULL) {
                $configuration['additionalParams'] .= '&tx_news_pi1[action]=' . $action;
            }

            $link = parent::render($newsItem, $settings, $hsc, $configuration);

            // ignore the getDynamicGetVarsManipulation settings, which can cause the action to be added hardcoded (which is only applicable for news only items)
            if(stristr($link, urlencode('tx_news_pi1[action]') . '=detail') !== FALSE) {
                $link = str_replace(urlencode('tx_news_pi1[action]') . '=detail', urlencode('tx_news_pi1[action]') . '=' . $action, $link);
            }
        } else {
            $link = parent::render($newsItem, $settings, $hsc, $configuration);
        }

        return $link;
    }

}