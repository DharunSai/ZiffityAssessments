<?php

namespace Tasks\Feedback\Observer;
use Psr\Log\LoggerInterface;

class SetDisplayText  implements \Magento\Framework\Event\ObserverInterface
{
    public $logger;

    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $displayText = $observer->getEvent()->getData('data');
        $name = $displayText->getfirstname();
        $this->logger->info('My Observer Called'.$name);
    }
}
