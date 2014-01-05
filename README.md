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

Copy the file [`/app/config/parameters.yml.dist`](/app/config/parameters.yml.dist) to `/app/config/parameters.yml` and update the following parameters:

```yaml
parameters:
    aws_api_key:            APIKEY
    aws_api_secret:         APISECRET
    aws_iam_role:           IAMROLE
    aws_instance_role:      INSTANCEROLE
```

The easiest way to get the `aws_iam_role` and `aws_instance_role` is to create a stack through the aws console. The console will automatically generate these roles for you. After the stack has been created you can get these values from the **Stack Settings** page and re-use these accross different stacks, or use them to create new ones.

To create your own see [Inscence Profiles](http://docs.aws.amazon.com/IAM/latest/UserGuide/instance-profiles.html), [IAM Roles for Amazon EC2](http://docs.aws.amazon.com/AWSEC2/latest/UserGuide/iam-roles-for-amazon-ec2.html), and [Secure access to AWS Service APIs from EC2](http://aws.typepad.com/aws/2012/06/iam-roles-for-ec2-instances-simplified-secure-access-to-aws-service-apis-from-ec2.html).

##Usage
###Create new stack###
```
php app/console opsworks:create:stack name
``` 

####Arguments:####
 - **name:**                 Stack name.

###Enable and update custom chef settings###
```
php app/console opsworks:update:stack:chef stack type url ssh-key-path
``` 

####Arguments:####
 - **stack:**                 Stack ID.
 - **type:**                  Repository type.
 - **url:**                   Repository URL.
 - **revision:**              Revision or Branch.
 - **ssh-key-path:**          Path to ssh key.

####Options:####
 - **custom-json**            A string that contains user-defined, custom JSON. must be escaped.
 
###Create a new PHP layer###
```
php app/console opsworks:create:layer stack
``` 

####Arguments:####
 - **stack:**                 Stack ID.
 

###Update PHP layer lifecycle event recipes and OS Packages###
```
php app/console opsworks:update:layer layer --recipes-setup="..." --recipes-configure="..." --recipes-deploy="..." --recipes-undeploy="..." --recipes-shutdown="..." --os-packages="..."
``` 

####Arguments:####
 - **layer:**                 Stack ID.

####Options:####
 - **recipes-setup:**         Comma separated values of recipes to be run on setup.
 - **recipes-configre:**      Comma separated values of recipes to be run on configure.
 - **recipes-deploy:**        Comma separated values of recipes to be run on deploy.
 - **recipes-undeploy:**      Comma separated values of recipes to be run on undeploy.
 - **recipes-shutdown:**      Comma separated values of recipes to be run on shutdown.
 - **os-packages:**           Comma separated values of OS packages to be installed on the servers.

 
###Create Application###
```
php app/console opsworks:create:app stack  name --source-type="..." --source-url="..." --source-revision="..." --ssh-key-path="..."
``` 

####Arguments:####
 - **stack:**                 Stack ID.

####Options:####
 - **source-type:**           Repository type.
 - **source-url:**            Repository URL.
 - **source-revision:**       Revision or Branch.
 - **document-root**          Document Root.
 - **ssh-key-path:**          Path to ssh key.


###Update Application###
```
php app/console opsworks:update:app app  --source-type="..." --source-url="..." --source-revision="..." --ssh-key-path="..." --document-root="..."
```

####Arguments:####
 - **app:**                 Application ID.

####Options:####
 - **source-type:**           Repository type.
 - **source-url:**            Repository URL.
 - **source-revision:**       Revision or Branch.
 - **document-root**          Document Root.
 - **ssh-key-path:**          Path to ssh key.

 
###Update Application###
```
php app/console opsworks:update:app app  --source-type="..." --source-url="..." --source-revision="..." --ssh-key-path="..."
``` 

####Arguments:####
 - **app:**                   App ID.

####Options:####
 - **source-type:**           Repository type.
 - **source-url:**            Repository URL.
 - **source revision:**       Revision or Branch.
 - **ssh-key-path:**          Path to ssh key.
 

###Create and start instance###
```
php app/console opsworks:create:instance stack layer instance-type "--instance-number=..."
``` 

####Arguments:####
 - **stack:**                 Stack ID.
 - **layer:**                 Layer ID.
 - **instance-type:**         Type of EC2 Instance ie: m1.small.

####Options:####
 - **instance-number:**       Number of instances to start, defaults to one.
 
 
