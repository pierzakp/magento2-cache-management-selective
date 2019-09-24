<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Test\Unit\Plugin\Block\Backend\Cache;

use Magento\Backend\Block\Cache as Subject;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pierzakp\CacheManagementSelective\Plugin\Block\Backend\Cache\UpdateFlushMagentoCacheButton;

/**
 * Test case for plugin which updates flush magento cache button in admin
 * cache management page.
 */
class UpdateFlushMagentoCacheButtonTest extends TestCase
{
    /**
     * @var UpdateFlushMagentoCacheButton
     */
    private $object;

    /**
     * @var Subject|MockObject
     */
    private $subject;

    protected function setUp(): void
    {
        $this->subject = $this->getMockBuilder(Subject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new UpdateFlushMagentoCacheButton();
    }

    public function testBeforeSetLayout(): void
    {
        $this->subject->expects($this->once())
            ->method('updateButton');

        $this->object->beforeSetLayout($this->subject);
    }
}
