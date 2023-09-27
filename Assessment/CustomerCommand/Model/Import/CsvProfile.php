<?php
declare(strict_types=1);

namespace Assessment\CustomerCommand\Model\Import;

use Psr\Log\LoggerInterface;
use Assessment\CustomerCommand\Api\ProfileInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\Csv;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer as ResourceModel;

/**
 * Class CsvProfile
 *
 * @package Assessment\CustomerCommand\Model\Import
 */
class CsvProfile implements ProfileInterface
{
    /**
     * @var Csv
     */
    protected $csv;

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
     * CsvProfile constructor.
     * @param Csv $csv
     * @param ResourceModel $customerRepository
     * @param CustomerFactory $customerFactory
     * @param LoggerInterface $LoggerInterface
     */
    public function __construct(
        Csv $csv,
        ResourceModel $customerRepository,
        CustomerFactory $customerFactory,
        LoggerInterface $logger
    ) {
        $this->csv = $csv;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
    }

     /**
     * Import customer data from an array of data and save it in database.
     *
     * @param array $csvData
     */
    protected function importCustomers(array $csvData)
    {
        foreach ($csvData as $row) {
                list($firstname, $lastname, $email) = $row;
                $customer = $this->customerFactory->create();
                $customer->setFirstname($firstname);
                $customer->setLastname($lastname);
                $customer->setEmail($email);
                $customer->setWebsiteId(1);
                $customer->setGroupId(1);
                $this->customerRepository->save($customer);
                $this->logger->info('Customer imported successfully');
            }
        }

    /**
     * Import customer data from a CSV file.
     *
     * @param string $source The path to the CSV file
     */
    public function import($source)
    {
        try {
            $csvData = array_map('str_getcsv', file($source));
            $this->importCustomers($csvData,);
            
        } 
        catch (LocalizedException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
