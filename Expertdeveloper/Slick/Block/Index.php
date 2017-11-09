<?php
namespace Expertdeveloper\Slick\Block;   
class Index extends \Magento\Framework\View\Element\Template 
{
	protected $contactFactory;
	protected $helperFactory;
	public function __construct(
    \Magento\Backend\Block\Template\Context $context,
    \Expertdeveloper\Slick\Model\ContactFactory $contactFactory,
	\Magento\Catalog\Helper\ImageFactory $helperFactory,

    array $data = []
	) {
      $this->contactFactory = $contactFactory;
	  $this->helperFactory  = $helperFactory;
      parent::__construct($context, $data);
	}

    public function getSlides($slider_id){
    		
        $collection =  $this->contactFactory->create()->getCollection()->addFieldToFilter('contact_id',array('eq'=>$slider_id));
		return  $collection;
    } 
	public function getProducts($contact){ 
        $collections =  $this->contactFactory->create()->getProducts($contact);
		return  $collections;
    } 
	
		/**
	 * Retrieve product image
	 *
	 * @param \Magento\Catalog\Model\Product $product
	 * @param string $imageId
	 * @param array $attributes
	 * @return \Magento\Catalog\Block\Product\Image
	 */
	public function getImage($product, $imageId, $attributes = [])
	{
		$image = $this->helperFactory->create()->init($product, $imageId)
			->constrainOnly(true)
			->keepAspectRatio(true)
			->keepTransparency(true)
			->keepFrame(false)
			->resize(200, 300);

		return $image;
	}
}