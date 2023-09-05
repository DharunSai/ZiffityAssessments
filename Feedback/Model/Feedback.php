<?php
namespace Tasks\Feedback\Model;
use Magento\Framework\Model\AbstractModel;
class Feedback extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Feedback::class);
    }
    public function markAsAccepted($email)
    {
        $feedback = $this->load($email,'email');
        if ($feedback->getId()) {
            // Update the status to 'accepted'
            $feedback->setStatus(1);
            $feedback->save();
        }
    }
    public function markAsRejected($email)
    {
        $feedback = $this->load($email,'email');
        if ($feedback->getId()) {
            // Update the status to 'accepted'
            $feedback->setStatus(0);
            $feedback->save();
        }
    }
}
