<?php
namespace Webline\Donation\Service;

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Configuration
 * @package Webline\Donation\Service
 */
class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**#@+
     * Admin config XML Path constants
     * @var string
     */
    const XML_PATH = 'pp_product_donate/config';
    /**
     *
     */
    /**#@-*/

    protected $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    private $storeManager;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    private $imageHelper;

    /**
     * Configuration constructor.
     * @param Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManager $storeManager
     * @param \Magento\Catalog\Helper\Image $imageHelper
     */
    public function __construct(
        Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Catalog\Helper\Image $imageHelper
    )
    {
        parent::__construct($context);
        $this->scopeConfig              = $scopeConfig;
        $this->storeManager             = $storeManager;
        $this->imageHelper              = $imageHelper;
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function isModuleEnable($store = null)
    {
        return $this->_getConfig('enable', $store);
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function getTitle($store = null)
    {
        return $this->_getConfig('title', $store);
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function getDescription($store = null)
    {
        return $this->_getConfig('description', $store);
    }

    /**
     * @param null $store
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBannerUrl($store = null)
    {
        $configUrl = $this->_getConfig('banner', $store);

        if( !empty($configUrl) )
        {
            $bannerUrl = $this->storeManager->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ).'pp_Donation/banner/'.$configUrl;
        }else {
            $bannerUrl =  $this->imageHelper->getDefaultPlaceholderUrl('image');
        }
        return $bannerUrl;

    }

    /**
     * @param null $store
     * @return array|mixed
     */
    public function getDonateOptions($store = null)
    {
        $data =  $this->_getConfig('donate_options', $store);

        if (empty($data)) {
            return [];
        }

        $result = json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Unable to decode value. Error: ' . json_last_error_msg());
        }

        return $result;
    }

    /**
     * @param $field
     * @param null $store
     * @return mixed
     */
    private function _getConfig($field, $store = null) {

        $fullPath = sprintf('%s/%s', self::XML_PATH, $field);

        return $this->scopeConfig->getValue(
            $fullPath,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}
