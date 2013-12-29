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
class UpdatePHPLayerCommand extends OpsWorksCommand
{
    protected function configure()
    {
        $this
            ->setName('opsworks:update:layer')
            ->setDescription('Update a layer.')
            ->addArgument(
                'layer',
                InputArgument::REQUIRED,
                'Layer ID'
            )
            ->addOption(
                'recipes-setup',
                null,
                InputOption::VALUE_REQUIRED,
                'Recipe Names'
            )
            ->addOption(
                'recipes-configure',
                null,
                InputOption::VALUE_REQUIRED,
                'Recipe Names'
            )
            ->addOption(
                'recipes-deploy',
                null,
                InputOption::VALUE_REQUIRED,
                'Recipe Names'
            )
            ->addOption(
                'recipes-undeploy',
                null,
                InputOption::VALUE_REQUIRED,
                'Recipe Names'
            )
            ->addOption(
                'recipes-shutdown',
                null,
                InputOption::VALUE_REQUIRED,
                'Recipe Names'
            )
            ->addOption(
                'os-packages',
                null,
                InputOption::VALUE_REQUIRED,
                'Recipe Names'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get Arguments
        $layerId = $input->getArgument('layer');
        $customRecipes = array();
        $customRecipes['Setup'] = explode(',', $input->getOption('recipes-setup'));
        $customRecipes['Configure'] = explode(',', $input->getOption('recipes-configure'));
        $customRecipes['Deploy'] = explode(',', $input->getOption('recipes-deploy'));
        $customRecipes['Undeploy'] = explode(',', $input->getOption('recipes-undeploy'));
        $customRecipes['Shutdown'] = explode(',', $input->getOption('recipes-shutdown'));

        $osPackages = explode(',', $input->getOption('os-packages'));

        $this->client->updateLayer(array(
            'LayerId' => $layerId,
            'CustomRecipes' => $this->filterValues($customRecipes),
            'Packages' => $this->filterValues($osPackages),
        ));

        $output->writeln('<info>SUCCESS! Layer updated</info>');
    }

    private function filterValues(array $options)
    {
        foreach($options as $key=>$value)
        {
            if($value[0] == '' || empty($value)) {
                unset($options[$key]);
            }
        }

        return $options;
    }
}
