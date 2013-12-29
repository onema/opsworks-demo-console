<?php

/*
 * This file is part of the Onema OpsWorks Demo Console. 
 * For the full copyright and license information, 
 * please view the LICENSE file that was distributed 
 * with this source code.
 */

namespace Onema\OpsWorksConsole\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of GenerateReportCommand
 *
 * @author Juan Manuel Torres <kinojman@gmail.com>
 * @copyright (c) 2013-2014, Onema
 */
class UpdateStackChefCommand extends OpsWorksCommand
{
    protected function configure()
    {
        $this
            ->setName('opsworks:update:stack:chef')
            ->setDescription('Simple Stack update.')
            ->addArgument(
                'stack',
                InputArgument::REQUIRED,
                'Stack ID'
            )
            ->addArgument(
                'type',
                InputArgument::REQUIRED,
                'Repository Type'
            )
            ->addArgument(
                'url',
                InputArgument::REQUIRED,
                'Repository URL'
            )
            ->addArgument(
                'revision',
                InputArgument::REQUIRED,
                'Revision or branch'
            )
            ->addArgument(
                'ssh-key-path',
                InputArgument::REQUIRED,
                'Path to ssh key'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get Arguments
        $stackId = $input->getArgument('stack');
        $type    = $input->getArgument('type');
        $url     = $input->getArgument('url');
        $revision = $input->getArgument('revision');

        $sshKey  = $this->getShhKeyFromPath($input->getArgument('ssh-key-path'));
        
        $this->client->updateStack(array(
            // StackId is required
            'StackId' => $stackId,
            'ServiceRoleArn' => $this->parameters['aws_iam_role'],
            'UseCustomCookbooks' => true,
            'CustomCookbooksSource' => array(
                'Type' => $type,
                'Url'  => $url,
                'SshKey' => $sshKey,
                'Revision' => $revision,
            ),
        ));
        
        $output->writeln('<info>SUCCESS!</info>');
    }
}
