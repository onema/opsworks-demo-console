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

##Usage

```
php app/console opsworks:update:stack:chef stack type url ssh-key-path
``` 

Arguments:
 - stack                 Stack ID
 - type                  Repository type
 - URL                   Repository URL
 - ssh-key-path          Path to ssh key
