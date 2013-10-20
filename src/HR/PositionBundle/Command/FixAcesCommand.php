<?php
namespace HR\PositionBundle\Command;

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

        $positionAcl     = $this->getContainer()->get('position.acl');
        $positionManager = $this->getContainer()->get('position.manager.default');

        $foundPositionAcls   = 0;
        $createdPositionAcls = 0;

        foreach ($positionManager->findAllPositions() as $position) {
            $oid = new ObjectIdentity($position->getId(), get_class($position));

            try {
                $provider->findAcl($oid);
                $foundPositionAcls++;
            } catch (AclNotFoundException $e) {
                $positionAcl->setDefaultAcl($position);
                $createdPositionAcls++;
            }
        }

        $output->writeln("Found {$foundPositionAcls} Position Acl Entries, Created {$createdPositionAcls} Position Acl Entries");
    }
}