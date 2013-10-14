<?php
namespace HR\Bundle\JobBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class InstallAcesCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('hr:acl:installAces')
            ->setDescription('Installs global ACEs')
            ->setDefinition(array(
                new InputOption('flush', null, InputOption::VALUE_NONE, 'Flush existing Acls')
            ))->setHelp(<<<EOT
This command should be run once during the installation process of the entire bundle or
after enabling Acl for the first time.
EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->getContainer()->has('security.acl.provider')) {
            $output->writeln('You must setup the ACL system, see the Symfony2 documentation for how to do this.');

            return;
        }

        $jobAcl = $this->getContainer()->get('job.acl');

        if ($input->getOption('flush')) {
            $output->writeln('Flushing Global ACEs');

            $jobAcl->uninstallFallbackAcl();
        }

        $jobAcl->installFallbackAcl();

        $output->writeln('Global ACEs have been installed.');
    }
}