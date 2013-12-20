<?php
/*
 * This file is part of the CPCStrategy {OpsWorks} Package. 
 * For the full copyright and license information, 
 * please view the LICENSE file that was distributed 
 * with this source code.
 */
namespace Onema\OpsWorksConsole\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CreateStackCommand - Description. 
 *
 * @author Juan Manuel Torres <kinojman@gmail.com>
 * @copyright (c) 2013, CPC Strategy Development Team
 */
class CreateStackCommand extends OpsWorksCommand
{
    protected function configure()
    {
        $this
            ->setName('opsworks:create:stack')
            ->setDescription('Create a stack.')
            ->addArgument(
                'name',
                null,
                InputArgument::REQUIRED,
                'Stack ID'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get Arguments
        $stackName = $input->getArgument('name');

        $result = $this->client->createStack(array(
            'Name' => $stackName,
            'Region' => $this->parameters['aws_region'],
            'ServiceRoleArn' => $this->parameters['aws_iam_role'],
            'DefaultInstanceProfileArn' => $this->parameters['aws_instance_role'],
        ));

        $output->writeln('<info>SUCCESS! Stack ID: '.$result['StackId']. '</info>');
    }
}
