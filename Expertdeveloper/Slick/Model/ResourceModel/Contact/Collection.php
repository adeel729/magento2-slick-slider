<?php
namespace Expertdeveloper\Slick\Model\ResourceModel\Contact;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'contact_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Expertdeveloper\Slick\Model\Contact', 'Expertdeveloper\Slick\Model\ResourceModel\Contact');
    }
}
