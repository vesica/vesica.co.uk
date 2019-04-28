[![CircleCI](https://circleci.com/gh/meezaan/microservice-template.svg?style=svg)](https://circleci.com/gh/meezaan/microservice-template)

# Introduction
This is PHP 7 based microservice template that can greatly speed up building of microservices.

# Technology Stack

* PHP 7.1
* MySQL 5.7 / PerconaDB 5.7
* Memcached
* Slim Framework v3

# How to use it
This is effectively a starter template. You can make changes in the src and the routes folder and have your microservice up and running in a few minutes (depending on what you're trying to do, of course).

## Understanding the Structure

The template uses a variety of composer packages. The list is available in composer.json. Many of these are optional - look in src/Model to see which ones may be used.

### The src Folder
This starts with namespace definition. The example has a namespace called Book. Inside our namespace, we have:

1. Entities - These are Doctrine entities - we're using Doctrine as an ORM here - so you can create and manage your schema with these.
2. Models - These contain any business logic you need to apply incoming our outgoing data.
3. Helpers - Any generic classes to help you do stuff can go here - if you're not using any third party composer packages.

### The routes folder
This contains your microservice routes. It comes with versioned folders and the file within is self explanatory. We don't have controllers on purpose - they make you think like a monolith. A routes file will likely force you into a microservice mindset.

## Create a Project with this template

Run:
```
composer create-project --stability dev meezaan/microservice-template project-name
```

# Other stuff - the below documentation is not yet complete. Stay tuned.


This template comes packaged with several different tools (via composer). Using all of them is optional. You can choose to use them or remove them as you wish. You can even add your own. Below are some useful commands and links to documentation for the tools used:

* Doctrine (ORM and DBAL) - http://www.doctrine-project.org/projects/orm.html
* ApiGen (PHP Documentation) - https://github.com/ApiGen/ApiGen
* MicroService Helper - https://github.com/meezaan/microservice-helper
* PHP Unit - https://phpunit.de/
* Mockery for PHP Unit - http://docs.mockery.io/en/latest/
* Behat and Mink - http://behat.org/en/latest/ and http://mink.behat.org/en/latest/
* PHP CodeSiffer - https://github.com/squizlabs/PHP_CodeSniffer
* PHP Mess Detector - https://phpmd.org/
* Slim Basic Auth
* Slim JWT Auth
* Slim Validation
* ApiDocJS - A Javascript / nodejs based tool to generate pretty API Documentation - http://apidocjs.com/

See composer.json to add / remove packages as you need them.

## Doctrine
Generate Entities (getters and setters) ``` vendor/bin/doctrine orm:generate-entities src/```

Generate Proxies ``` vendor/bin/doctrine orm:generate-proxies ```

Update ``` vendor/bin/doctrine orm:schema-tool:update```

Create ``` vendor/bin/doctrine orm:schema-tool:create```

## Behat
```
vendor/bin/behat -dl
```

## PHPUnit
```
vendor/bin/phpunit
```

## PHP Mess Detector
Run the following to see your options and run a report
```
vendor/bin/phpmd src/
```

## PHP Code Sinffer
To see issues:
```
vendor/bin/phpcs src/
```

To autofix per PSR-2:
```
vendor/bin/phpcbf src/
```

## Generate PHP docs
```
vendor/bin/apigen generate src/ --destination docs/php
```

## ApiDocJS API Documentation
This requires ```npm```. To install:

```
npm install apidoc -g
```

To run:
```
apidoc -i routes/ -o docs/api/
```



# To Do
Add docs about artifacts produced.

```
Feature Toggling / flagging
```
