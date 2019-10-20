<?php
namespace Tereta\Import\Controller\Adminhtml\Edit;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Tereta\Import\Model\ImportFactory;
use Magento\Framework\View\Result\PageFactory;

class Run extends Action
{
    /**
     * @var ImportFactory
     */
    protected $importFactory;

    /**
     * Run constructor.
     * @param PageFactory $resultPageFactory
     * @param ImportFactory $importFactory
     * @param Context $context
     */
    public function __construct(ImportFactory $importFactory, Context $context)
    {
        $this->importFactory = $importFactory;
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
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $importId = $this->getRequest()->getParam('import_id');
        $importModel = $this->importFactory->create();

        echo "<html><body>";
        try {
            $importModel->setHtmlOutput(true);
            $importModel->importById($importId);
        } catch (\Exception $e) {
            echo('<div class="error">Stopping error: ' . $e->getMessage() . '; In: ' . $e->getFile() . ':' . $e->getLine() . '; Trace:' . $e->getTraceAsString() . '</div>');
        }
        echo "</body></html>";
    }
}