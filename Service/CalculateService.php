<?php
namespace Webline\Donation\Service;

use Magento\Framework\DataObject;
use Magento\Quote\Model\Quote;

/**
 * Class CalculateService
 * @package Webline\Donation\Service
 */
class CalculateService
{
    /**
     * @var
     */
    private $sumDonateValue;

    /**
     * @param Quote $quote
     * @return DataObject
     */
    public function calculate(Quote $quote) {

        if ( null === $this->sumDonateValue ) {
            $sum = [
                'base_pp_donate_fee' => 0,
                'pp_donate_fee'      => 0,
            ];

            $allItems = $quote->getAllItems();

            foreach ( $allItems as $item ) {
                $sum['base_pp_donate_fee'] += $item->getBasePpDonateFee();
                $sum['pp_donate_fee'] += $item->getPpDonateFee();
            }

            $this->sumDonateValue = $sum;
        }

        return new DataObject($this->sumDonateValue);
    }
}
