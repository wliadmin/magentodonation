<?php
namespace Webline\Donation\Block\Adminhtml\Sales;

/**
 * Class Totals
 * @package Webline\Donation\Block\Adminhtml\Sales
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
    public function getOrder()
    {
        return $this->getParentBlock()->getOrder();
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->currency->getCurrencySymbol();
    }

    /**
     * @return $this
     */
    public function initTotals()
    {
        $this->getParentBlock();
        $this->getOrder();
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
                'label' => __($this->configuration->getTitle()),
            ]
        );
        $this->getParentBlock()->addTotalBefore($total, 'grand_total');


        return $this;
    }
}
