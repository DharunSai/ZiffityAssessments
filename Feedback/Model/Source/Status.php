<?php
/**
 * Status Source Model for Feedback Status
 *
 * @package Tasks\Feedback\Model\Source
 */
namespace Tasks\Feedback\Model\Source;
use \Magento\Framework\Option\ArrayInterface;

/**
 * Status Class
 *
 * @api
 */
class Status implements ArrayInterface
{
    /**
     * Status constants
     */
    public const REJECTED = 0;
    public const APPROVED = 1;
    public const PROCESSING = 2;

    /**
     * Get options as an array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getOptionArray();
    }

    /**
     * Get option array
     *
     * @param bool $excludeNew
     * @return array
     */
    public function getOptionArray($excludeNew = false)
    {
        $options = [
            ['value' => self::PROCESSING, 'label' => __('Processing')],
            ['value' => self::APPROVED, 'label' => __('Approved')],
            ['value' => self::REJECTED, 'label' => __('Rejected')]
        ];
        return $options;
    }

    /**
     * Get status label
     *
     * @param int $status
     * @return string
     */
    public function getStatusLabel($status)
    {
        $statusLabel = '';
        $options = $this->toOptionArray();
        foreach ($options as $option) {
            if ($option['value'] == $status) {
                $statusLabel = $option['label'];
                break;
            }
        }
        return $statusLabel;
    }

    /**
     * Get visible statuses on the frontend
     *
     * @return array
     */
    public function getVisibleOnFrontStatuses()
    {
        return [self::REJECTED, self::APPROVED, self::PROCESSING];
    }
}

