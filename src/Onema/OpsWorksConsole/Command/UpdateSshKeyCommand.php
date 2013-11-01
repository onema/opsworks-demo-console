<?php

/*
 * This file is part of the Onema OpsWorks Demo Console. 
 * For the full copyright and license information, 
 * please view the LICENSE file that was distributed 
 * with this source code.
 */

namespace Onema\OpsWorksConsole\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

use Aws\OpsWorks\OpsWorksClient;

/**
 * Description of GenerateReportCommand
 *
 * @author Juan Manuel Torres <kinojman@gmail.com>
 * @copyright (c) 2013-2014, Onema
 */
class UpdateSshKeyCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('opsworks:update:sshkey')
            ->setDescription('Simple Stack update.')
            ->addArgument(
                'stack',
                InputArgument::REQUIRED,
                'Stack ID'
            )
            ->addArgument(
                'arn-role',
                InputArgument::REQUIRED,
                'Service Role Arn'
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
        $arn = $input->getArgument('arn-role');
        $sshKeyPath = $input->getArgument('ssh-key-path');
        
        // Get configuration values
        $path = __DIR__.'/../../../../app/config/parameters.yml';
        $realPath = realpath($path);
        $config = Yaml::parse($realPath);
        $parameters = $config['parameters'];
        
        // Get SSH Key from path
        $handle = fopen($sshKeyPath, 'r');
        $sshKey = fread($handle, filesize($sshKeyPath));
        
        // Create OpsWorks Client and update stack
        $client = OpsWorksClient::factory(array(
            'key'    => $parameters['aws_api_key'],
            'secret' => $parameters['aws_api_secret'],
            'region' => $parameters['aws_region'],
        ));
        
        $result = $client->updateStack(array(
            // StackId is required
            'StackId' => $stackId,
            'ServiceRoleArn' => $arn,
            'CustomCookbooksSource' => array(
                'SshKey' => $sshKey,
            ),
        ));
        
        $output->writeln('<info>SUCCESS!</info>');
    }
}
