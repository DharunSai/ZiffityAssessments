<?php
declare(strict_types=1);

namespace Assessment\CustomerCommand\Model\Import;

use Psr\Log\LoggerInterface;
use Assessment\CustomerCommand\Api\ProfileInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\ResourceModel\Customer as CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Serialize\SerializerInterface; // Add this use statement

/**
 * Class JsonProfile
 *
 * @package Assessment\CustomerCommand\Model\Import
 */
class JsonProfile implements ProfileInterface
{
   /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var serializer
     */
    protected $serializer; // Add this property

    public function __construct(
        CustomerFactory $customerFactory,
        CustomerRepositoryInterface $customerRepository,
        LoggerInterface $logger,
        SerializerInterface $serializer // Inject SerializerInterface
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
        $this->serializer = $serializer; // Store the injected SerializerInterface
    }

     /**
     * Import customer data from an array of data and save it in database.
     *
     * @param array $customerDataArray
     */
    protected function importCustomers(array $customerDataArray)
    {
        foreach ($customerDataArray as $customerData) {
            $customer = $this->customerFactory->create();
            $customer->setFirstname($customerData['fname']);
            $customer->setLastname($customerData['lname']);
            $customer->setEmail($customerData['emailaddress']);
            $customer->setWebsiteId(1);
            $customer->setGroupId(1); // Default customer group ID
            $this->customerRepository->save($customer);
            $this->logger->info('Customer imported successfully');
        }
    }

    public function import($source)
    {
        try {
            $jsonData = file_get_contents($source);
            $data = $this->serializer->unserialize($jsonData); // Use the serializer to unserialize JSON
            $this->importCustomers($data);
        } 
        catch (LocalizedException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
