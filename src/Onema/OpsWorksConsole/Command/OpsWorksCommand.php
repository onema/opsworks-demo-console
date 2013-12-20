<?php
/*
 * This file is part of the CPCStrategy {OpsWorks} Package. 
 * For the full copyright and license information, 
 * please view the LICENSE file that was distributed 
 * with this source code.
 */
namespace Onema\OpsWorksConsole\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Yaml\Yaml;

use Aws\OpsWorks\OpsWorksClient;

/**
 * OpsWorksCommand - Description. 
 *
 * @author Juan Manuel Torres <kinojman@gmail.com>
 * @copyright (c) 2013, CPC Strategy Development Team
 */
class OpsWorksCommand  extends Command
{
    protected $client;
    protected $parameters;

    public function __construct()
    {
        parent::__construct();

        // Get configuration values
        $path = realpath(__DIR__.'/../../../../app/config/parameters.yml');
        $config = Yaml::parse($path);
        $this->parameters = $config['parameters'];

        // Create OpsWorks Client and update stack
        $this->client = OpsWorksClient::factory(array(
            'key'    => $this->parameters['aws_api_key'],
            'secret' => $this->parameters['aws_api_secret'],
            'region' => $this->parameters['aws_region'],
        ));
    }
}