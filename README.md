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
###Create new stack###
```
php app/console opsworks:create:stack name
``` 

Arguments:
 - name                 Stack name

###Enable and update custom chef settings###
```
php app/console opsworks:update:stack:chef stack type url ssh-key-path
``` 

Arguments:
 - stack                 Stack ID
 - type                  Repository type
 - URL                   Repository URL
 - revision              Revision or Branch
 - ssh-key-path          Path to ssh key
 
 
###Create a new PHP layer###
```
php app/console opsworks:create:layer stack
``` 

Arguments:
 - stack                 Stack ID
 

###Update PHP layer lifecycle event recipes and OS Packages###
```
php app/console opsworks:update:layer layer --recipes-setup="..." --recipes-configure="..." --recipes-deploy="..." --recipes-undeploy="..." --recipes-shutdown="..." --os-packages="..."
``` 

Arguments:
 - layer                 Stack ID

Options:
 - recipes-setup         Comma separated values of recipes to be run on setup.
 - recipes-configre      Comma separated values of recipes to be run on configure.
 - recipes-deploy        Comma separated values of recipes to be run on deploy.
 - recipes-undeploy      Comma separated values of recipes to be run on undeploy.
 - recipes-shutdown      Comma separated values of recipes to be run on shutdown.
 - os-packages           Comma separated values of OS packages to be installed on the servers.
 

```
php app/console opsworks:create:app stack  name --source-type="..." --source-url="..." --source-revision="..." --ssh-key-path="..."
``` 

Arguments:
 - stack                 Stack ID

Options:
 - source-type           Repository type
 - Source URL            Repository URL
 - source revision       Revision or Branch
 - ssh-key-path          Path to ssh key
 

```
php app/console opsworks:create:instance stack layer instance-type
``` 

Arguments:
 - stack                 Stack ID
 - layer                 Layer ID
 - Instance type         Type of EC2 Instance ie: m1.small
 
