<?php
/*
 * This file is part of the CPCStrategy {OpsWorks} Package. 
 * For the full copyright and license information, 
 * please view the LICENSE file that was distributed 
 * with this source code.
 */
namespace Onema\OpsWorksConsole\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CreateStackCommand - Description. 
 *
 * @author Juan Manuel Torres <kinojman@gmail.com>
 * @copyright (c) 2013, CPC Strategy Development Team
 */
class CreateAppCommand extends OpsWorksCommand
{
    protected function configure()
    {
        $this
            ->setName('opsworks:create:app')
            ->setDescription('Create an app.')
            ->addArgument(
                'stack',
                InputArgument::REQUIRED,
                'Stack ID'
            )
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'App Name'
            )
            ->addOption(
                'source-type',
                null,
                InputOption::VALUE_REQUIRED,
                'Type of VCS'
            )
            ->addOption(
                'source-url',
                null,
                InputOption::VALUE_REQUIRED,
                'URL to repository'
            )
            ->addOption(
                'source-revision',
                null,
                InputOption::VALUE_REQUIRED,
                'Repository version or revision'
            )
            ->addOption(
                'ssh-key-path',
                null,
                InputOption::VALUE_REQUIRED,
                'Repository version or revision'
            )

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get Arguments
        $stackId = $input->getArgument('stack');
        $name = $input->getArgument('name');

        $options = array(
            'StackId'   => $stackId,
            'Type'      => 'php',
            'Name'      => $name,
            'Shortname' => $name,
        );

        $options['AppSource']['Type'] = $input->getOption('source-type');
        $options['AppSource']['Url']  = $input->getOption('source-url');
        $options['AppSource']['Revision'] = $input->getOption('source-revision');
        $options['AppSource']['SshKey']   = $this->getShhKeyFromPath($input->getOption('ssh-key-path'));

        $result = $this->client->createApp($options);

        $output->writeln('<info>SUCCESS! App ID: '.$result['AppId']. '</info>');
    }
}
