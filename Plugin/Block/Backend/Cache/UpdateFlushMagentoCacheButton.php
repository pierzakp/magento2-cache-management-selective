<?php
declare(strict_types=1);

namespace Pierzakp\CacheManagementSelective\Plugin\Block\Backend\Cache;

use Magento\Backend\Block\Cache as Subject;

/**
 * Plugin object which updates flush magento cache button.
 */
class UpdateFlushMagentoCacheButton
{
    /**
     * @param Subject $subject
     *
     * @return void
     */
    public function beforeSetLayout(Subject $subject): void
    {
        $subject->updateButton(
            'flush_magento',
            'class',
            'flush-cache-storage'
        );
    }
}
