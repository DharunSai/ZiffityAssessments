<?php
namespace Tasks\Feedback\Model\Source;
class Status implements \Magento\Framework\Option\ArrayInterface
{
    public const REJECTED = 0;
    public const APPROVED = 1;
    public const PROCESSING = 2;
    /** @return array*/
    public function toOptionArray()
    {
        return $this->getOptionArray();
    }
    public function getOptionArray($excludeNew = false)
    {
        $options = [['value' => self::PROCESSING, 'label' => __('Processing')], ['value' => self::APPROVED, 'label' => __('Approved')], ['value' => self::REJECTED, 'label' => __('Rejected')]];
        return $options;
    }
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
    /*** @return array */
    public function getVisibleOnFrontStatuses()
    {
        return [self::REJECTED, self::APPROVED, self::PROCESSING];
    }
}
