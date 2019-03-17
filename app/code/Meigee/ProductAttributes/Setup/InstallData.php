<?php

namespace Meigee\ProductAttributes\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Api\Data\ProductAttributeInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $attribute = 'test_attrbiute';
        $entityTypeId = ProductAttributeInterface::ENTITY_TYPE_CODE;
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        /**
         * Adding an attribute to default group
         */
        $attributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);
        $attributeGroupId = $eavSetup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);
        $groupName = $eavSetup->getAttributeGroup($entityTypeId, $attributeSetId, $attributeGroupId, 'attribute_group_name');

        $eavSetup->addAttribute($entityTypeId, $attribute, [
            'label'                      => 'Test Attribute',
            'user_defined'               => 1,
            'searchable'                 => 1,
            'visible_on_front'           => 1,
            'visible_in_advanced_search' => 1,
            'group'                      => $groupName,
            'sort_order'                 => 10,
        ]);

        /**
         * Adding an attribute to a custom group
         */
        $attribute2 = 'test_attrbiute2';
        $attributeId = $eavSetup->getAttributeId($entityTypeId, $attribute2);
        $customGroupName = 'Meigee';

        $eavSetup->addAttribute($entityTypeId, $attribute2, [
            'label'                      => 'Test Attribute 2',
            'user_defined'               => 1,
            'searchable'                 => 1,
            'visible_on_front'           => 1,
            'visible_in_advanced_search' => 1,
            'group'                      => $customGroupName,
            'sort_order'                 => 10,
        ]);
        $eavSetup->addAttributeGroup($entityTypeId, $attributeSetId, $customGroupName, 10);
        $eavSetup->addAttributeToGroup($entityTypeId, $attributeSetId, $customGroupName, $attributeId);
    }
}
