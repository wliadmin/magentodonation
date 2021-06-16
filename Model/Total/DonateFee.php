<?php
namespace Webline\Donation\Model\Total;

use Magento\Framework\Phrase;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;

/**
 * Class DonateFee
 * @package Webline\Donation\Model\Total
 */
class DonateFee extends Address\Total\AbstractTotal
{
    /**
     * @var \Webline\Donation\Service\Configuration
     */
    private $configuration;

    private $calculateService;

    /**
     * DonateFee constructor.
     * @param \Webline\Donation\Service\Configuration $configuration
     */
    public function __construct(
        \Webline\Donation\Service\Configuration $configuration,
        \Webline\Donation\Service\CalculateService $calculateService
    )
    {
        $this->configuration         = $configuration;
        $this->calculateService      = $calculateService;
    }

    /**
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Address\Total $total
     * @return $this
     */
    public function collect(Quote $quote, ShippingAssignmentInterface $shippingAssignment, Address\Total $total)
    {
        parent::collect($quote, $shippingAssignment, $total);

        $sumDonateValue = $this->calculateService->calculate($quote);

        $total->setTotalAmount('pp_donate_fee', $sumDonateValue->getPpDonateFee());
        $total->setBaseTotalAmount('base_pp_donate_fee', $sumDonateValue->getBasePpDonateFee());
        $total->setPpDonateFee($sumDonateValue->getPpDonateFee());
        $total->setBasePpDonateFee($sumDonateValue->getBasePpDonateFee());
        $quote->setPpDonateFee($sumDonateValue->getPpDonateFee());
        $quote->setBasePpDonateFee($sumDonateValue->getBasePpDonateFee());
        $quote->setGrandTotal($total->getGrandTotal() + $sumDonateValue->getPpDonateFee());
        $quote->setBaseGrandTotal($total->getBaseGrandTotal() + $sumDonateValue->getBasePpDonateFee());

        return $this;
    }

    /**
     * @param Address\Total $total
     */
    protected function clearValues(Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }

    /**
     * Assign subtotal amount and label to address object
     *
     * @param Quote $quote
     * @param Address\Total $total
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(Quote $quote, Address\Total $total)
    {

        $result = [
            'code' => 'pp_donate_fee',
            'title' => $this->getLabel(),
            'value' => $this->calculateService->calculate($quote)->getPpDonateFee()
        ];

        return $result;
    }

    /**
     * Get label
     *
     * @return Phrase
     */
    public function getLabel()
    {
        return __($this->configuration->getTitle());
    }
}
