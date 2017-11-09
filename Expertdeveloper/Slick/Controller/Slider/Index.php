<?php
namespace Expertdeveloper\Slick\Controller\Slider;
use Magento\Framework\App\Action\Context;
class Index extends \Magento\Framework\App\Action\Action 
{
    protected $_resultPageFactory;

    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory){
        $this->_resultPageFactory = $resultPageFactory; 
        parent::__construct($context); 
    }

    public function execute() {
        $resultPage = $this->_resultPageFactory->create(); 
	     $resultPage->addHandle('slick_slider_index'); //loads the layout of module_custom_customlayout.xml file with its name
        return $resultPage; 
		
    }
}
