<?php

namespace Assessment\CustomerCommand\Model\Import;

use Assessment\CustomerCommand\Api\ProfileInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\ResourceModel\Customer as CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;

/**
 * @IgnoreAnnotation("ORM")
 *
 * @ORM\Entity
 * @ORM\Table(name="import_profiles")
 */

class JsonProfile implements ProfileInterface
{

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;


    /**
     * JsonProfile constructor.
     * @param CustomerFactory $customerFactory
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        CustomerFactory $customerFactory,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Import customer data from a JSON file.
     *
     * @param string $source The path to the JSON file
     */
    public function import($source)
    {
        try {
            $jsonData = file_get_contents($source);
            $data = json_decode($jsonData, true);
            foreach ($data as $customerData) {
                $customer = $this->customerFactory->create();
                $customer->setFirstname($customerData['fname']);
                $customer->setLastname($customerData['lname']);
                $customer->setEmail($customerData['emailaddress']);
                $customer->setWebsiteId(1);
                $customer->setGroupId(1); // Default customer group ID
                $this->customerRepository->save($customer);
                print_r('successfully updated');
            }
            
        } catch (LocalizedException $e) {
            print_r($e->getMessage());
        }
    }
}
