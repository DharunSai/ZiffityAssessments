<?php

namespace Assessment\CustomerCommand\Model\Import;

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
     */

    public function __construct(
        Csv $csv,
        ResourceModel $customerRepository,
        CustomerFactory $customerFactory
    ) {
        $this->csv = $csv;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
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
            $csvHeaders = array_shift($csvData);
            foreach ($csvData as $row) {
                list($firstname, $lastname, $email) = $row;
                $customer = $this->customerFactory->create();
                $customer->setFirstname($firstname);
                $customer->setLastname($lastname);
                $customer->setEmail($email);
                $customer->setWebsiteId(1);
                $customer->setGroupId(1);
                $this->customerRepository->save($customer);
                print_r('successfully updated');
            }
        } 
        catch (LocalizedException $e) {
            print_r( $e->getMessage() );
        }
    }
}
