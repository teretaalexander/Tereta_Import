<?php
namespace Tereta\Import\Controller\Adminhtml\Edit;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Tereta\Import\Model\ImportFactory as ModelImportFactory;

/**
 * Class Delete
 * @package Tereta\Import\Controller\Adminhtml\Edit
 */
class Delete extends Action
{
    /**
     * @var ModelImportFactory
     */
    protected $modelImportFactory;

    /**
     * Delete constructor.
     * @param ModelImportFactory $modelImportFactory
     * @param Context $context
     */
    public function __construct(
        ModelImportFactory $modelImportFactory,
        Context $context
    )
    {
        $this->modelImportFactory = $modelImportFactory;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Tereta_Import::import');
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $modelImport = $this->modelImportFactory->create();
        $resultRedirect = $this->resultRedirectFactory->create();

        $entityId = $this->getRequest()->getParam('entity_id');

        if ($entityId) {
            try{
                $modelImport->load($entityId);
                $modelImport->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the configuration.'));
            }
            catch(\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('advencedimport/listing/index/');
    }
}