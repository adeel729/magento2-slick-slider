<?php
namespace Expertdeveloper\Slick\Block\Adminhtml\Contact\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $store;

    /**
    * @var \Expertdeveloper\Slick\Helper\Data $helper
    */
    protected $helper;
    protected $category;
	protected $categoryRepository;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Expertdeveloper\Slick\Helper\Data $helper,
		\Magento\Catalog\Helper\Category $category,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        array $data = []
    ) {
        $this->helper = $helper;
	    $this->category = $category;
        $this->categoryRepository = $categoryRepository;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \Expertdeveloper\Slick\Model\Contact */
        $model = $this->_coreRegistry->registry('ws_contact');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('contact_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Slider Information')]);

        if ($model->getId()) {
            $fieldset->addField('contact_id', 'hidden', ['name' => 'contact_id']);
        }

        $fieldset->addField(
            'contact_name',
            'text',
            [
                'name' => 'contact_name',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
            ]
        );
		
		$fieldset->addField(
            'center_image_width',
            'text',
            [
                'name' => 'center_image_width',
                'label' => __('Center Image Width'),
                'title' => __('Center Image Width'),
                'required' => false,
				 'note'      => __('for example: 400px'),
            ]
        );
		
		$fieldset->addField(
            'thumbnail_width',
            'text',
            [
                'name' => 'thumbnail_width',
                'label' => __('Thumbnail Width'),
                'title' => __('Thumbnail Width'),
                'required' => false,
				 'note'      => __('for example: 400px'),
            ]
        );
		
		$fieldset->addField(
            'arrows_top',
            'text',
            [
                'name' => 'arrows_top',
                'label' => __('Arrows Top Space'),
                'title' => __('Arrows Top Space'),
                'required' => false,
				 'note'      => __('for example: 100%'),
            ]
        );
		
		$fieldset->addField(
            'text_bottom',
            'text',
            [
                'name' => 'text_bottom',
                'label' => __('Title Top Space'),
                'title' => __('Title Top Space'),
                'required' => false,
				 'note'      => __('for example: 10%'),
            ]
        );
		
		
		$fieldset->addField(
        'categories',
        'multiselect',
        [
                'name' => 'categories[]',
                'label' => __('Categories'),
                'title' => __('Categories'),
                'required' => false,
                'values' => $this->getValueArray(),
                'disabled' => false

        ]
    );
		
      
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Detail');
    }
    public function getValueArray()
	{
		$options=array();
		$i=0;
		$categories = $this->category->getStoreCategories();
        foreach($categories as $category) {
			
            $options[$i]['label']= $category->getName();
			$options[$i]['value']= $category->getId();
            $categoryObj = $this->categoryRepository->get($category->getId());
            $subcategories = $categoryObj->getChildrenCategories();
            foreach($subcategories as $subcategorie) {
				$i++;
				$options[$i]['label']= '  '.$subcategorie->getName();
				$options[$i]['value']= $subcategorie->getId();
            }
        $i++;}
		return $options;
	}
    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Detail');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
