<?php
namespace Webline\Donation\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;

/**
 * Class ProductAddToCartAfter
 * @package Webline\Donation\Observer
 */
class ProductAddToCartAfter implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * @var \Magento\Directory\Helper\Data
     */
    private $directoryHelper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * ProductAddToCartAfter constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Directory\Helper\Data $directoryHelper
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Directory\Helper\Data $directoryHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    )
    {
        $this->request          = $request;
        $this->directoryHelper  = $directoryHelper;
        $this->storeManager     = $storeManager;
        $this->priceCurrency    = $priceCurrency;
    }

    /**
     * @param EventObserver $observer
     * @return $this|void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(EventObserver $observer)
    {
        if ( !empty($this->request->getParam('is_donate')) ) {

            $item = $observer->getQuoteItem();

            $donateValue = $this->request->getParam('donate_value');

            $baseCurrencyCode = $this->storeManager->getStore()->getBaseCurrencyCode();

            $currencyCode = $this->storeManager->getStore()->getCurrentCurrency()->getCode();

            $fee = $item->getPpDonateFee() ? $item->getPpDonateFee() : 0;

            $baseFee = $item->getBasePpDonateFee() ? $item->getBasePpDonateFee() : 0;

            $fee += $this->priceCurrency->round($donateValue);

            $baseFee += $this->priceCurrency->round($this->directoryHelper->currencyConvert($donateValue, $currencyCode, $baseCurrencyCode));

            $item->setBasePpDonateFee($baseFee);

            $item->setPpDonateFee($fee);
        }

        return $this;
    }
}
