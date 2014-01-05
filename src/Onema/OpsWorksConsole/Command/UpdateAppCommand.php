<?php
/*
 * This file is part of the Onema {OpsWorks} Package.
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
 * @copyright (c) 2013, onema.io
 */
class UpdateAppCommand extends OpsWorksCommand
{
    protected function configure()
    {
        $this
            ->setName('opsworks:update:app')
            ->setDescription('Update an app.')
            ->addArgument(
                'app',
                InputArgument::REQUIRED,
                'App ID'
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
            ->addOption(
                'document-root',
                null,
                InputOption::VALUE_REQUIRED,
                'Document root'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get Arguments
        $stackId = $input->getArgument('app');

        $options = array(
            'AppId'   => $stackId,
        );

        $options['AppSource']['Type'] = $input->getOption('source-type');
        $options['AppSource']['Url']  = $input->getOption('source-url');
        $options['AppSource']['Revision'] = $input->getOption('source-revision');
        $options['AppSource']['SshKey']   = $this->getShhKeyFromPath($input->getOption('ssh-key-path'));
        $options['Attributes']['DocumentRoot'] = $input->getOption('document-root');

        $result = $this->client->updateApp($options);

        $output->writeln('<info>SUCCESS!</info>');
    }
}
