<?php

declare(strict_types=1);

namespace Assessment\CustomerCommand\Console\Command;

use Assessment\CustomerCommand\Api\ProfileInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use \Magento\Framework\Console;

/**
 * Class ImportCustomerCommand
 *
 * @package Assessment\CustomerCommand\Console\Command
 */
class ImportCustomerCommand extends Command
{
    private const NAME = 'name';
    protected $profiles;
    const COMMAND_NAME = 'customer:importer';

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
     * Configure the command
     */
    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('This is my first console command.');

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
            if (isset($this->profiles[$profile])) {
                $this->profiles[$profile]->import($source);
            } else {
                $output->writeln('<error>Invalid profile. Supported profiles: csv, json</error>');
            }
            return Cli::RETURN_SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Cli::RETURN_FAILURE;
        }
    }
}
