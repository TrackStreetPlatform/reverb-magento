<?php

/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */

namespace TrackStreet\Integration\Helper;

use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package TrackStreet\Integration\Helper
 */
class Data extends \TrackStreet\Core\Helper\Data
{
    /**
     * Get the saved setting for the Reverb API consumer key value.
     * 
     * @author Christophe Sautot
     * @return string
     */
    public function getConsumerKey()
    {
        return $this->scopeConfig->getValue(self::PATH . 'consumer_key', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the saved setting for the Reverb API consumer secret value.
     * 
     * @author Christophe Sautot
     * @return string
     */
    public function getConsumerSecret()
    {
        return $this->scopeConfig->getValue(self::PATH . 'consumer_secret', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the saved setting for the domain used to host Reverb widgets.
     * 
     * @author Christophe Sautot
     * @return string
     */
    public function getReverbWidgetDomain()
    {
        return $this->scopeConfig->getValue(self::PATH . 'reverb_widget_domain', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the saved setting for the domain that is used by the Reverb API.
     * 
     * @author Christophe Sautot
     * @return string
     */
    public function getReverbAPIDomain()
    {
        return $this->scopeConfig->getValue(self::PATH . 'reverb_api_domain', ScopeInterface::SCOPE_STORE);
    }
}

?>