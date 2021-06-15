<?php

/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Core\Helper;

use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package TrackStreet\Core\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Base configuration path
     */
    const PATH = 'trackstreet/settings/';

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(self::PATH . 'enable', ScopeInterface::SCOPE_STORE) == 1;
    }

    /**
     * @return mixed
     */
    public function getReferralProgramUuid()
    {
        return $this->scopeConfig->getValue(self::PATH . 'referral_program_uuid', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getStoreUuid()
    {
        return $this->scopeConfig->getValue(self::PATH . 'store_uuid', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the version of our main Reverb widget JavaScript file.
     * 
     * @author Christophe Sautot
     * @return string
     */
    public function getScriptVersion() 
    {
        return '1.05'; // Updated on 2021-06-02 by Christophe Sautot
    }

    /**
     * @return string
     */
    public function getScriptUrl() 
    {
        $js_version = str_replace('.', '_', $this->getScriptVersion());

        return "https://rs.trackstreet.com/reverb/prod/js/reverb_{$js_version}_min.js";
    }

    /**
     * @return string
     */
    public function getWidgetServerUrl() 
    {
        // $this->scopeConfig->getValue(self::PATH . 'consumer_key', ScopeInterface::SCOPE_STORE);
        return 'https://' . $this->scopeConfig->getValue(self::PATH . 'reverb_widget_domain', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getAdminUrl() 
    {
        return '//reverb.trackstreet.com';
    }
}