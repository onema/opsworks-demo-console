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
class CreatePHPLayerCommand extends OpsWorksCommand
{
    protected function configure()
    {
        $this
            ->setName('opsworks:create:layer')
            ->setDescription('Create a layer.')
            ->addArgument(
                'stack',
                null,
                InputArgument::REQUIRED,
                'Stack ID'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get Arguments
        $stackId = $input->getArgument('stack');

        $result = $this->client->createLayer(array(
            'StackId' => $stackId,
            'Type' => 'php-app',
            'Name' => 'PHP App Server',
            'Shortname' => 'php-app-server-'.time(),
        ));

        $output->writeln('<info>SUCCESS! Layer ID: '.$result['LayerId']. '</info>');
    }
}
