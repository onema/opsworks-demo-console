opsworks-demo-console
=====================

Simple CLI tool to interact with AWS OpsWorks using the AWS SDK for PHP v2.


##Installation

```
git clone git@github.com:onema/opsworks-demo-console.git
cd opsworks-demo-console
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

Copy the file ```app/config/parameters.yml.dist``` to ```app/config/parameters.yml```

In **parameters.yml** update the parameters ```aws_api_key``` and ```aws_api_secret``` to be valid 
Amazon API Key and API Secret.

##Usage

```
php app/console opsworks:update:stack:chef stack type url ssh-key-path
``` 

Arguments:
 - stack                 Stack ID
 - type                  Repository type
 - URL                   Repository URL
 - ssh-key-path          Path to ssh key
