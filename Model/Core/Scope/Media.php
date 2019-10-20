<?php
namespace Tereta\Import\Model\Core\Scope;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject;
use Tereta\Import\Model\Core\Scope\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Tereta\Import\Model\Logger;
use Tereta\Import\Model\ResourceModel\Core\Scope\Media as MediaResource;

/**
 * Tereta\Import\Model\Core\Scope\Media
 *
 * Class Media
 * @package Tereta\Import\Model\Core\Scope
 */
class Media extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(MediaResource::class);
        $this->getResource()->setConfiguration($this->configuration)->setLogger($this->logger);
    }

    protected function getMediaImageField()
    {
        return 'image_url';
    }

    public function getSkipAttributes()
    {
        return [$this->getMediaImageField()];
    }

    public function collect(&$data)
    {
        if (!isset($data[$this->getMediaImageField()]) || !$data[$this->getMediaImageField()]) {
            return;
        }
        $this->getResource()->collect($data['sku'], $data, $data[$this->getMediaImageField()]);
    }

    public function fillEntityIds($skuEntities)
    {
        $this->getResource()->fillEntityIds($skuEntities);
    }

    public function getIncludeAttributes()
    {
        return ['image', 'small_image', 'swatch_image', 'thumbnail'];
    }

    public function save()
    {
        $this->getResource()->saveCollectedMedia();
    }
}