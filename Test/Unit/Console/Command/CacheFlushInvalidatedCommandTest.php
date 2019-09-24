<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Test\Unit\Console\Command;

use Magento\Framework\Console\Cli;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pierzakp\CacheManagementSelective\Console\Command\CacheFlushInvalidatedCommand;
use Pierzakp\CacheManagementSelective\Service\CacheManagement;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Test case for console command used for flushing invalidated cache.
 */
class CacheFlushInvalidatedCommandTest extends TestCase
{
    /**
     * @var CacheFlushInvalidatedCommand
     */
    private $object;

    /**
     * @var CacheManagement|MockObject
     */
    private $cacheManagement;

    protected function setUp(): void
    {
        $this->cacheManagement = $this->getMockBuilder(CacheManagement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new CacheFlushInvalidatedCommand($this->cacheManagement);
    }

    public function testExecuteNoResults(): void
    {
        $this->cacheManagement->method('getInvalidatedTypes')
            ->willReturn([]);

        $this->cacheManagement->expects($this->never())
            ->method('flushInvalidatedTypes');

        $commandTester = new CommandTester($this->object);
        $result = $commandTester->execute([]);

        $this->assertContains(
            'There are no invalidated cache types to be flushed',
            $commandTester->getDisplay()
        );
        $this->assertEquals(
            Cli::RETURN_SUCCESS,
            $result
        );
    }

    public function testExecuteWithResults(): void
    {
        $this->cacheManagement->method('getInvalidatedTypes')
            ->willReturn(['config', 'full_page']);

        $this->cacheManagement->expects($this->once())
            ->method('flushInvalidatedTypes');

        $commandTester = new CommandTester($this->object);
        $result = $commandTester->execute([]);

        $this->assertContains(
            'Following invalidated cache types has been flushed: config, full_page',
            $commandTester->getDisplay()
        );
        $this->assertEquals(
            Cli::RETURN_SUCCESS,
            $result
        );
    }
}
