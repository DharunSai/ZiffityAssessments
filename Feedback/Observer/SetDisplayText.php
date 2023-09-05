<?php

namespace Tasks\Feedback\Observer;
use Psr\Log\LoggerInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SetDisplayText  implements ObserverInterface
{
    public $logger;

    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $displayText = $observer->getEvent()->getData('data');
        $name = $displayText->getfirstname();
        $this->logger->info('My Observer Called'.$name);
    }
}
