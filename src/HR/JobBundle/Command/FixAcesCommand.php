<?php
namespace HR\JobBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Exception\AclNotFoundException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class FixAcesCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('hr:acl:fixAces')
            ->setDescription('Fixes Object Ace entries')
            ->setHelp(<<<EOT
This command will fix all Ace entries for existing objects. This command only needs to
be run when there are Objects that do not have Ace entries.
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

        $provider = $this->getContainer()->get('security.acl.provider');

        $jobAcl     = $this->getContainer()->get('job.acl');
        $jobManager = $this->getContainer()->get('job.manager.default');

        $foundJobAcls   = 0;
        $createdJobAcls = 0;

        foreach ($jobManager->findAllJobs() as $job) {
            $oid = new ObjectIdentity($job->getId(), get_class($job));

            try {
                $provider->findAcl($oid);
                $foundJobAcls++;
            } catch (AclNotFoundException $e) {
                $jobAcl->setDefaultAcl($job);
                $createdJobAcls++;
            }
        }

        $output->writeln("Found {$foundJobAcls} Job Acl Entries, Created {$createdJobAcls} Job Acl Entries");
    }
}