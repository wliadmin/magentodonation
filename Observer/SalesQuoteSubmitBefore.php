<?php
namespace Webline\Donation\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;

/**
 * Class SalesQuoteSubmitBefore
 * @package Webline\Donation\Observer
 */
class SalesQuoteSubmitBefore implements ObserverInterface
{
    /**
     * @param EventObserver $observer
     * @return $this|void
     */
    public function execute(EventObserver $observer)
    {
        $quote = $observer->getQuote();

        $extraFee = $quote->getPpDonateFee();

        $extraBaseFee = $quote->getBasePpDonateFee();

        if (!$extraFee || !$extraBaseFee) {
            return $this;
        }

        $order = $observer->getOrder();

        $order->setData('pp_donate_fee', $extraFee);

        $order->setData('base_pp_donate_fee', $extraBaseFee);

        return $this;
    }
}
