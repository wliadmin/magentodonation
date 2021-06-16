<?php
namespace Webline\Donation\Model\ResourceModel\Order\Grid;

use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as OriginalCollection;

/**
 * Class Collection
 * @package Webline\Donation\Model\ResourceModel\Order\Grid
 */
class Collection extends OriginalCollection
{

    /**
     *
     */
    protected function _renderFiltersBefore()
    {
        $this->getSelect()->joinLeft(
            ['so' => $this->getConnection()->getTableName('sales_order')],
            'main_table.entity_id = so.entity_id',
            array('base_pp_donate_fee','pp_donate_fee')
        )
            ->distinct();

        parent::_renderFiltersBefore();
    }

    /**
     * @return OriginalCollection|void
     */
    protected function _initSelect()
    {

        $this->addFilterToMap('created_at', 'main_table.created_at');

        parent::_initSelect();
    }

}
