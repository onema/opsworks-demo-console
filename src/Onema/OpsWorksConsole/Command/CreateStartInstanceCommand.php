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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CreateStackCommand - Description. 
 *
 * @author Juan Manuel Torres <kinojman@gmail.com>
 * @copyright (c) 2013, CPC Strategy Development Team
 */
class CreateStartInstanceCommand extends OpsWorksCommand
{
    protected function configure()
    {
        $this
            ->setName('opsworks:create:instance')
            ->setDescription('Create N number of instance.')
            ->addArgument(
                'stack',
                InputArgument::REQUIRED,
                'Stack ID'
            )
            ->addArgument(
                'layer',
                InputArgument::REQUIRED,
                'Layer ID'
            )
            ->addArgument(
                'instance-type',
                InputArgument::REQUIRED,
                'Instance Type'
            )
            ->addOption(
                'instance-number',
                null,
                InputOption::VALUE_REQUIRED,
                'Number of instances to create, defaults to 1'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get Arguments
        $stackId = $input->getArgument('stack');
        $layerId = $input->getArgument('layer');
        $instanceType = $input->getArgument('instance-type');
        $instanceNumber = ($input->getOption('instance-number')) ? $input->getOption('instance-nuber') : 1;

        for ($i = 0; $i < $instanceNumber; $i++) {
            $result = $this->client->createInstance(array(
                'StackId' => $stackId,
                'LayerIds' => array($layerId),
                'InstanceType' => $instanceType,
                'DefaultInstanceProfileArn' => $this->parameters['aws_instance_role'],
            ));

            $output->writeln('<info>SUCCESS! Instance ID: '.$result['InstanceId']. '</info>');

            $instanceResult = $this->client->startInstance(array(
                'InstanceId' => $result['InstanceId']
            ));

            $output->writeln('<info>SUCCESS! Instance ID: '.$instanceResult['InstanceId']. ' Started</info>');
        }
    }
}
