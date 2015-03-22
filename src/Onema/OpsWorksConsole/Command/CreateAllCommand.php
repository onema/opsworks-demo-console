<?php
/*
 * This file is part of the Onema {OpsWorks} Package.
 * For the full copyright and license information, 
 * please view the LICENSE file that was distributed 
 * with this source code.
 */
namespace Onema\OpsWorksConsole\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Command\Command;
use Onema\OpsWorksConsole\Exception\RunTimeException;

/**
 * CreateStackCommand - Description. 
 *
 * @author Juan Manuel Torres <kinojman@gmail.com>
 * @copyright (c) 2013, onema.io
 */
class CreateAllCommand extends OpsWorksCommand
{
    private $stackId;
    private $layerId;
    private $sourceUrl;
    private $sshKeyPath;

    protected function configure()
    {
        $this
            ->setName('opsworks:create:all')
            ->setDescription('Create a full stack.')
            ->addArgument(
                'source-url',
                InputArgument::REQUIRED,
                'Stack ID'
            )
            ->addArgument(
                'ssh-key-path',
                InputArgument::REQUIRED,
                'Stack ID'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->sourceUrl  = $input->getArgument('source-url');
        $this->sshKeyPath = $input->getArgument('ssh-key-path');
        echo $this->stackId = $this->createStack() . PHP_EOL;
        echo $this->updateStack() . PHP_EOL;
        echo $this->layerId = $this->createLayer() . PHP_EOL;
        echo $this->updateLayer() . PHP_EOL;
        echo $this->createApp() . PHP_EOL;
        echo $this->startServer() . PHP_EOL;
    }

    private function createStack()
    {
        $command = $this->getApplication()->find('opsworks:create:stack');

        $arguments = array(
            'command' => 'opsworks:create:stack',
            'name'    => 'sdphp-console-auto',
        );

        $outputText = $this->runCommand($command, $arguments);
        return $this->getId($outputText);
    }

    private function updateStack()
    {
        $command = $this->getApplication()->find('opsworks:update:stack:chef');

        $arguments = array(
            'command' => 'opsworks:update:stack:chef',
            'stack'   => $this->stackId,
            'type'    => 'git',
            'url'     => 'git@github.com:onema/opsworks-chef-cookbooks.git',
            'revision'=> 'master',
            'ssh-key-path' => $this->sshKeyPath,
        );

        return $this->runCommand($command, $arguments);
    }

    private function createLayer()
    {
        $command = $this->getApplication()->find('opsworks:create:layer');

        $arguments = array(
            'command' => 'opsworks:create:layer',
            'stack'   => $this->stackId,
        );

        $outputText = $this->runCommand($command, $arguments);
        return $this->getId($outputText);
    }

    private function updateLayer()
    {
        $command = $this->getApplication()->find('opsworks:update:layer');

        $arguments = array(
            'command' => 'opsworks:update:layer',
            'layer'   => $this->layerId,
            '--recipes-setup'  => 'phpenv::memoryswap',
            '--recipes-deploy' => 'composer::install',
            '--os-packages'    => 'acl,php-apc,php-pear,php5-intl',
        );

        return $this->runCommand($command, $arguments);
    }

    private function createApp()
    {
        $command = $this->getApplication()->find('opsworks:create:app');

        $arguments = array(
            'command' => 'opsworks:create:app',
            'stack'   => $this->stackId,
            'name'    => 'sd_php_app_auto',
            '--source-type'  => 'git',
            '--source-url'   => $this->sourceUrl,
            '--source-revision' => 'master',
            '--ssh-key-path' => $this->sshKeyPath,
        );

        return $this->runCommand($command, $arguments);
    }

    private function startServer()
    {
        $command = $this->getApplication()->find('opsworks:create:instance');

        $arguments = array(
            'command' => 'opsworks:create:instance',
            'stack'   => $this->stackId,
            'layer'   => $this->layerId,
            'instance-type' => 'c1.medium',
        );

        return $this->runCommand($command, $arguments);
    }

    private function runCommand(Command $command, $arguments)
    {
        $output = new BufferedOutput();
        $input = new ArrayInput($arguments);
        $code = $command->run($input, $output);

        if($code == 0) {
            $text = $output->fetch();
            return $text;
        } else {
            throw new RunTimeException('There where problems while executing command '.$command->getName());
        }
    }

    private function getId($text)
    {
        $values = explode(': ', $text);
        return $values[1];
    }
}
