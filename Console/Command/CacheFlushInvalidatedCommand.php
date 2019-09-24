<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Console\Command;

use Magento\Framework\Console\Cli;
use Pierzakp\CacheManagementSelective\Service\CacheManagement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for flushing invalidated cache.
 */
class CacheFlushInvalidatedCommand extends Command
{
    /**
     * @var CacheManagement
     */
    private $cacheManagement;

    /**
     * @param CacheManagement $cacheManagement
     * @param string|null $name
     */
    public function __construct(
        CacheManagement $cacheManagement,
        string $name = \null
    ) {
        parent::__construct($name);

        $this->cacheManagement = $cacheManagement;
    }

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('pierzakp:cache:flush-invalidated');
        $this->setDescription('Flush invalidated cache types');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $invalidatedTypes = $this->cacheManagement->getInvalidatedTypes();

        if ($invalidatedTypes) {
            $this->cacheManagement->flushInvalidatedTypes();

            $output->writeln(\sprintf(
                '<info>%s %s</info>',
                'Following invalidated cache types has been flushed:',
                \implode(', ', $invalidatedTypes)
            ));
        } else {
            $output->writeln(\sprintf(
                '<info>%s</info>',
                'There are no invalidated cache types to be flushed'
            ));
        }

        return Cli::RETURN_SUCCESS;
    }
}
