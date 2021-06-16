<?php
namespace Webline\Donation\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class DonateOptions
 * @package Webline\Donation\Block\Adminhtml\System\Config
 */
class DonateOptions extends AbstractFieldArray
{
    CONST COLUMN_NAME = 'donate_option';

    /**
     * @var bool
     */
    protected $_addAfter = false;

    /**
     * @var
     */
    protected $_addButtonLabel;

    /**
     * Construct
     */
    protected function _construct() {
        parent::_construct();
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare to render the columns
     */
    protected function _prepareToRender() {
        $this->addColumn(self::COLUMN_NAME, ['label' => __('Option')]);
    }

    /**
     * Render array cell for prototypeJS template
     *
     * @param string $columnName
     * @return string
     * @throws \Exception
     */
    public function renderCellTemplate($columnName)
    {
        if ($columnName == self::COLUMN_NAME) {
            $this->_columns[$columnName]['class'] = 'input-text required-entry validate-number';
        }
        return parent::renderCellTemplate($columnName);
    }
}
