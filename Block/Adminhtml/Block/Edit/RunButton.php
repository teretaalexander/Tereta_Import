<?php
namespace Tereta\Import\Block\Adminhtml\Block\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Tereta\Import\Block\Adminhtml\Block\Edit\RunButton\Template as RunButtonTemplate;

/**
 * Tereta\Import\Block\Adminhtml\Block\Edit\RunButton
 *
 * Class RunButton
 * @package Tereta\Import\Block\Adminhtml\Block\Edit
 */
class RunButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Run'),
            'import_id' => $this->getEntityId(),
            'sort_order' => 10,
            'class_name' => RunButtonTemplate::class
        ];
    }
}