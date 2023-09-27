<?php
declare(strict_types=1);

namespace Assessment\CustomerCommand\Console\Command;

use Assessment\CustomerCommand\Api\ProfileInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Console;

/**
 * Class ImportCustomerCommand
 *
 * @package Assessment\CustomerCommand\Console\Command
 */
class ImportCustomerCommand extends Command
{
    /**
     * The NAME constant represents a placeholder for a string.
     * It is declared as 'name'.
     * @var string
     */
    private const NAME = 'name';

    /**
     * The profiles property holds an array of profile objects.
     * @var ProfileInterface[]
     */
    protected $profiles;

    /**
     * The COMMAND_NAME constant represents the name of the console command.
     * It is declared as 'customer:importer'.
     * @var string
     */
    const CUSTOMER_COMMAND_NAME = 'customer:importer';

    /**
     * ImportCustomerCommand constructor.
     *
     * @param ProfileInterface $csvProfile
     * @param ProfileInterface $jsonProfile
     */
    public function __construct(ProfileInterface $csvProfile, ProfileInterface $jsonProfile)
    {
        $this->profiles = [
            'csv' => $csvProfile,
            'json' => $jsonProfile,
        ];

        parent::__construct();
    }

    /**
     * Configure the details for the custom command
     */
    protected function configure(): void
    {
        $this->setName(self::CUSTOMER_COMMAND_NAME);
        $this->setDescription('This is my first console command.');

        // Add an option named 'profile'
        $this->addOption(
            'profile', 
            null,
            InputOption::VALUE_REQUIRED, 
            'profile' 
        );
       
        $this->addArgument(
            'source', 
            null 
        );

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $profile = $input->getOption('profile');
        $source = $input->getArgument('source');

        try {
            switch ($profile) {
                case 'csv':
                    $this->profiles['csv']->import($source);
                    return Cli::RETURN_SUCCESS;
                case 'json':
                    $this->profiles['json']->import($source);
                    return Cli::RETURN_SUCCESS;
                default:
                    $output->writeln('<error>Invalid profile. Supported profiles: csv, json</error>');
                    return Cli::RETURN_FAILURE;
            }
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Cli::RETURN_FAILURE;
        }
        
    }
}
