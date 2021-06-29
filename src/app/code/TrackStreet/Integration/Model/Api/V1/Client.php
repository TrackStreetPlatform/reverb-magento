<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Model\Api\V1;

/**
 * Class Client
 * @package TrackStreet\Integration\Model\V1
 */
class Client implements \TrackStreet\Integration\Api\ReverbServiceInterface
{
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \TrackStreet\Integration\Helper\Data
     */
    protected $helper;

    /**
     * @var \TrackStreet\Integration\Logger\ReverbApiLogger
     */
    protected $reverbApiLogger;

    /**
     * Client constructor.
     * @param \TrackStreet\Integration\Helper\Data $helper
     * @param \TrackStreet\Integration\Logger\ReverbApiLogger $reverbApiLogger
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetadata
     * @param \Magento\Framework\UrlInterface $urlBuilder
     */
    public function __construct(
        \TrackStreet\Integration\Helper\Data $helper,
        \TrackStreet\Integration\Logger\ReverbApiLogger $reverbApiLogger,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        \Magento\Framework\UrlInterface $urlBuilder
    )
    {
        $this->productMetadata = $productMetadata;
        $this->urlBuilder = $urlBuilder;
        $this->helper = $helper;
        $this->reverbApiLogger = $reverbApiLogger;
    }

    /**
     * @param $action
     * @param $data
     * @return array|false|mixed|object|resource
     */
    public function put($action, $data)
    {
        return $this->send([
            CURLOPT_CUSTOMREQUEST=>'PUT',
            CURLOPT_URL => $this->getActionUrl($action),
            CURLOPT_POSTFIELDS=> json_encode($data)
        ]);
    }


    /**
     * @param $action
     * @param $data
     * @return array|false|mixed|object|resource
     */
    public function post($action, $data)
    {
        return $this->send([
            CURLOPT_URL => $this->getActionUrl($action),
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS=> json_encode($data)
        ]);
    }

    /**
     * @param $action
     * @return array|bool|false|float|int|mixed|object|\Services_JSON_Error|string|void
     */
    public function get($action)
    {
        return $this->send([
            CURLOPT_URL => $this->getActionUrl($action)
        ]);
    }

    /**
     * @param $action
     * @return array|bool|false|float|int|mixed|object|\Services_JSON_Error|string|void
     */
    public function delete($action)
    {
        return $this->send([
            CURLOPT_URL => $this->getActionUrl($action),
            CURLOPT_CUSTOMREQUEST=>'DELETE',
        ]);
    }


    /**
     * @param $action
     * @return string
     */
    protected function getActionUrl($action) 
    {
        $action = str_replace(':store_uid:', $this->helper->getStoreUuid(), $action);

        $reverb_api_domain_setting = $this->helper->getReverbAPIDomain();

        $reverb_api_domain = $reverb_api_domain_setting == '' || empty($reverb_api_domain_setting) ? 'reverbapi.trackstreet.com' : $reverb_api_domain_setting;

        return 'https://' . $reverb_api_domain . '/api/v1/' . $action;
    }

    /**
     * @return string
     */
    protected function getAuth() 
    {
        return $this->helper->getConsumerKey() .':'.$this->helper->getConsumerSecret();
    }

    /**
     * @return string
     */
    protected function getUserAgent()
    {
        $user_agent = 
            $this->productMetadata->getName()
            . '/' . $this->productMetadata->getVersion()
            . ' (' . $this->productMetadata->getEdition() . ')';

        return $user_agent;
    }

    /**
     * @param array $config
     * @return array|bool|false|float|int|mixed|object|\Services_JSON_Error|string|void
     */
    protected function send($config = [])
    {
        try 
        {
            $client = curl_init();

            $configDefault = [
                CURLOPT_USERPWD => $this->getAuth(),
                CURLOPT_USERAGENT => $this->getUserAgent(),
                CURLOPT_FAILONERROR => FALSE,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_FOLLOWLOCATION => TRUE,
                //CURLOPT_SSL_VERIFYHOST => 0,
                //CURLOPT_SSL_VERIFYPEER => 0
            ];

            $this->reverbApiLogger->debug('Request: '.$config[CURLOPT_URL]);

            if (isset($config[CURLOPT_POSTFIELDS])) 
            {
                $this->reverbApiLogger->debug('Request Body: ' . \json_encode($config[CURLOPT_POSTFIELDS]));
            }

            foreach ($configDefault as $option => $value) 
            {
                curl_setopt($client, $option, $value);
            }

            foreach ($config as $option => $value) 
            {
                curl_setopt($client, $option, $value);
            }

            $result = curl_exec($client);
            
            $this->reverbApiLogger->debug('Response: '.$result);
            
            $result = \json_decode($result, true);

            if (\json_last_error() !== JSON_ERROR_NONE) 
            {
                $result = [
                    'response' => ['code' => 500, 'message' => \json_last_error_msg()]
                ];

                $this->reverbApiLogger->debug('ERROR: '.$result['response']['message']);
            }

        } catch (\Exception $exception) 
        {
            $result = ['response'=>['code'=>500,'message'=>$exception->getMessage()]];

            $this->reverbApiLogger->debug('ERROR: '.$exception->getMessage());
        } 
        finally 
        {
            curl_close($client);
        }

        return $result;
    }


}