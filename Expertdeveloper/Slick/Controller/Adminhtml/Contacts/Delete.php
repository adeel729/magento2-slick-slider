<?php

namespace Expertdeveloper\Slick\Controller\Adminhtml\Contacts;

use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;

class Delete extends \Magento\Backend\App\Action
{

    /**
     * {@inheritdoc}
     */
    /*protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Expertdeveloper_Contact::atachment_delete');
    }*/

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('contact_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Expertdeveloper\Slick\Model\Contact');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The slide has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['contact_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a slide to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
