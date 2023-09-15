<?php

namespace Assessment\CustomerCommand\Model\Import;

use Assessment\CustomerCommand\Api\ProfileInterface;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Json\Helper\Data as JsonHelper;
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
     * @var JsonHelper
     */
    protected $jsonHelper;
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * @var File
     */
    protected $driverFile;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * JsonProfile constructor.
     *
     * @param JsonHelper $jsonHelper
     * @param SerializerInterface $serializer
     * @param File $driverFile
     * @param CustomerFactory $customerFactory
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        JsonHelper $jsonHelper, // Inject the JSON helper
        SerializerInterface $serializer, // Inject the serializer
        File $driverFile, // Inject the filesystem driver
        CustomerFactory $customerFactory, // Inject the customer factory
        CustomerRepositoryInterface $customerRepository // Inject the customer repository
    ) {
        $this->jsonHelper = $jsonHelper; // Initialize the JSON helper
        $this->serializer = $serializer; // Initialize the serializer
        $this->driverFile = $driverFile; // Initialize the filesystem driver
        $this->customerFactory = $customerFactory; // Initialize the customer factory
        $this->customerRepository = $customerRepository; // Initialize the customer repository
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
        } catch (Exception $e) {
            print_r('<error>Error: ' . $e->getMessage() . '</error>');
        }
    }
}
