<?php

namespace Tereta\Import\Model\Core\Scope;

use Magento\Framework\DataObject;
use Tereta\Import\Model\Core\Scope\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Tereta\Import\Model\Logger;
use Tereta\Import\Model\ResourceModel\Core\Scope\Category as CategoryResource;

/**
 * Tereta\Import\Model\Core\Scope\Category
 *
 * Class Category
 * @package Tereta\Import\Model\Core\Sccollectope
 */
class Category extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(CategoryResource::class);
        $this->getResource()->setConfiguration($this->configuration)->setLogger($this->logger);
    }

    public function collect(&$data)
    {
        $this->getResource()->collect($data);
    }

    public function fillEntityIds($skuIds)
    {
        $this->getResource()->fillEntityIds($skuIds);
    }

    public function save()
    {
        $this->getResource()->saveProductCategories();
    }
}