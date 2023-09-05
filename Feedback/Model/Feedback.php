<?php

namespace Tasks\Feedback\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Feedback Model
 *
 * @package Tasks\Feedback\Model
 */
class Feedback extends AbstractModel
{
    /**
     * Initialize the model
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Feedback::class);
    }

    /**
     * Mark feedback as accepted
     *
     * @param string $email
     */
    public function markAsAccepted($email)
    {
        $feedback = $this->load($email, 'email');
        if ($feedback->getId()) {
            // Update the status to 'accepted'
            $feedback->setStatus(1);
            $feedback->save();
        }
    }

    /**
     * Mark feedback as rejected
     *
     * @param string $email
     */
    public function markAsRejected($email)
    {
        $feedback = $this->load($email, 'email');
        if ($feedback->getId()) {
            // Update the status to 'rejected'
            $feedback->setStatus(0);
            $feedback->save();
        }
    }
}
