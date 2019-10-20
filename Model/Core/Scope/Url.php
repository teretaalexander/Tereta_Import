<?php
namespace Tereta\Import\Model\Core\Scope;

use Tereta\Import\Model\Core\Scope\AbstractModel;
use Tereta\Import\Model\ResourceModel\Core\Scope\Url as UrlResource;

/**
 * Tereta\Import\Model\Core\Scope\Url
 *
 * Class Url
 * @package Tereta\Import\Model\Core\Scope
 */
class Url extends AbstractModel
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init(UrlResource::class);
        $this->getResource()->setConfiguration($this->configuration)->setLogger($this->logger);
    }

    /**
     * @return array
     */
    public function getIncludeAttributes()
    {
        return ['url_key'];
    }

    /**
     * @param $data
     */
    public function collect(&$data)
    {
        if ($this->configuration->getCreateUrlKey() && isset($data['name']) && $data['name'] && (!isset($data['url_key']) || !$data['url_key'])) {
            $data['url_key'] = $this->transformString($data['name'] . '_' . $data['sku']);
        }

        $this->getResource()->collect($data);
    }

    /**
     * @param $skuEntities
     */
    public function fillEntityIds($skuEntities)
    {
        $this->getResource()->fillEntityIds($skuEntities);
    }

    /**
     * @param $string
     * @return string
     */
    protected function transformString($string)
    {
        $cyrilic = [
            'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
            'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
            'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
            'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
        ];
        $latin = [
            'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
            'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
            'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
        ];

        $string = str_replace($cyrilic, $latin, $string);
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9]/U', '-', $string);

        while(strpos($string, "--") !== false) {
            $string = str_replace('--', '-', $string);
        }

        return trim($string, "-");
    }

    /**
     * @return \Magento\Framework\Model\AbstractModel|void
     */
    public function saveAfter()
    {
        $this->getResource()->saveUrl();
    }
}