<?php
namespace Webline\Donation\Model\Invoice\Total;

use Magento\Sales\Model\Order\Invoice;
use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;

/**
 * Class Fee
 * @package Prince\Extrafee\Model\Invoice\Total
 */
class DonateFee extends AbstractTotal
{
    // Model for invoice
    /**
     * @param Invoice $invoice
     * @return $this
     */
    public function collect(Invoice $invoice)
    {
        $invoice->setPpDonateFee(0);

        $invoice->setBasePpDonateFee(0);

        $amount = $invoice->getOrder()->getPpDonateFee();

        $invoice->setPpDonateFee($amount);

        $amount = $invoice->getOrder()->getBasePpDonateFee();

        $invoice->setBasePpDonateFee($amount);

        $invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getPpDonateFee());

        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getBasePpDonateFee());

        return $this;
    }
}
