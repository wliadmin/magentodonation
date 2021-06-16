<?php
namespace Webline\Donation\Block\Adminhtml\Sales\Order\Invoice;

/**
 * Class Totals
 * @package Webline\Donation\Block\Adminhtml\Sales\Order\Invoice
 */
class Totals extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Directory\Model\Currency
     */
    protected $currency;

    /**
     * @var \Webline\Donation\Service\Configuration
     */
    protected $configuration;

    /**
     * Totals constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Directory\Model\Currency $currency
     * @param \Webline\Donation\Service\Configuration $configuration
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Directory\Model\Currency $currency,
        \Webline\Donation\Service\Configuration $configuration,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->currency = $currency;
        $this->configuration    = $configuration;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * @return mixed
     */
    public function getInvoice()
    {
        return $this->getParentBlock()->getInvoice();
    }

    /**
     * @return $this
     */
    public function initTotals()
    {
        $this->getParentBlock();
        $this->getInvoice();
        $this->getSource();

        if(!$this->getSource()->getPpDonateFee()) {
            return $this;
        }
        $total = new \Magento\Framework\DataObject(
            [
                'code' => 'pp_donate_fee',
                'strong' => false,
                'value' => $this->getSource()->getPpDonateFee(),
                'base_value' => $this->getSource()->getBasePpDonateFee(),
                'label' => $this->configuration->getTitle(),
            ]
        );

        $this->getParentBlock()->addTotal($total, 'grand_total');
        return $this;
    }
}
