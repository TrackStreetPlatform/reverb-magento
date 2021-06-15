<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Console\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TrackStreet\Integration\Api\EntityProcessorPoolInterface;
use Symfony\Component\Console\Input\InputArgument;
/**
 * Class SyncCommand
 * @package TrackStreet\Integration\Console\Command
 */
class SyncCommand extends Command
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('trackstreet:reverb:sync')
            ->setDefinition($this->getInputList())
            ->setDescription('Synchronization data with TrackStreet Reverb');
        parent::configure();
    }


    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity =  $input->getArgument('entity');
        $ids = $input->getArgument('ids');

        if( $ids == 'all') {
            $ids = [];
        } else {
            $ids =  explode(',',$ids);
        }
        $entityProcessor = $this->objectManager->create("TrackStreet\Integration\Model\EntityProcessor\\".ucfirst($entity));
        if($entityProcessor) {
            $appState = $this->objectManager->get(\Magento\Framework\App\State::class);
            try {
                $appState->getAreaCode();
            } catch (\Exception $exception) {
                $appState->setAreaCode('adminhtml');
            }

            $entityProcessor->setOutput($output)->execute($ids);
        } else {
            $output->writeln("<error>$entity isn't exists<error>");
        }
    }

    /**
     * Get list of options and arguments for the command
     *
     * @return mixed
     */
    public function getInputList()
    {
        return [
            new InputArgument(
                'entity',
                InputArgument::REQUIRED,
                'Entity Type'
            ),
            new InputArgument(
                'ids',
                InputArgument::REQUIRED,
                'Entity_ids separate , or all'
            ),
        ];
    }
}
