<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Core\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Cms\Model\BlockFactory;

/**
 * Class AddCustomerUidAttribute
 * @package TrackStreet\Customer\Setup\Patch\Data
 */
class CmsBlockAdvocates implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * CmsBlockAdvocates constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param BlockFactory $blockFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        BlockFactory $blockFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /**
         * @var $block \Magento\Cms\Model\Block
         */
        $block = $this->blockFactory->create();
        $block->load('ts_advocates_block');
        if(!$block->getId()) {
            $block->setData([
                'identifier'=>'ts_advocates_block',
                'title'=>'TrackStreet Reverb Advocates Page Block',
                'content'=>'',
                'is_active' => 1,
                'stores' => [0]
            ]);
            $block->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getVersion()
    {
        return '0.0.1';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
