# Bluesmith

[![GitLab status](https://gitlab.oit.duke.edu/academic-technology/bluesmith/badges/develop/pipeline.svg)](https://gitlab.oit.duke.edu/academic-technology/bluesmith/commits/develop)
[![](https://github.com/duke-bluesmith/bluesmith/workflows/PHPUnit/badge.svg)](https://github.com/duke-bluesmith/bluesmith/actions?query=workflow%3A%22PHPUnit)
[![](https://github.com/duke-bluesmith/bluesmith/workflows/PHPStan/badge.svg)](https://github.com/duke-bluesmith/bluesmith/actions?query=workflow%3A%22PHPStan)
[![Coverage Status](https://coveralls.io/repos/github/duke-bluesmith/bluesmith/badge.svg?branch=develop)](https://coveralls.io/github/duke-bluesmith/bluesmith?branch=develop)

3D Print manager, Bluesmith (https://bluesmith.oit.duke.edu)

by Duke University OIT

(CodeIgniter 4 port of https://gitlab.oit.duke.edu/msg8/bluesmith)

## Requirements

**Bluesmith** is built on version 4 the CodeIgniter PHP framework. You will need to be
sure your environment meets all of the framework's
[system requirements](https://codeigniter4.github.io/userguide/intro/requirements.html).
Framework requirements may change but here is a good start:

* PHP 7.3 or newer
* PHP extensions (`php -m`): intl, json, mbstring, mysqlnd, xml, curl
* A database with one of the framework's supported drivers

Some additional requirements may depend on your choice of web host. See "Hosting with ..."
in the CodeIgniter [User Guide](https://codeigniter4.github.io/userguide/installation/running.html).

## Installation

### Overview

1. Clone or download the repository
2. Configure your environment
3. Run installation scripts

### Configure

1. In the root directory, copy **env** to **.env** and edit the new file:
	* Set `app.baseURL` to your site (with trailing slash), e.g. 'https://bluesmith.example.edu/'
	* Set all variables in the `DATABASE` section for the `default` group
	* `forceGlobalSecureRequests` is recommended but requires a valid HTTPS configuration
2. Set your web host to serve the **public/** directory

### Install/Upgrade

Run the provided **upgrade.sh** script which will do the following:

1. Install all packages and dependencies with the following command in the root directory:
	* `composer install`
2. Migrate the database:
	* `php spark migrate -all`
3. Seed the database with the necessary initial values:
	* `php spark db:seed InitialSeeder`
4. Publish asset files to the web root:
	* `php spark assets:publish`

## Customization

**Bluesmith** comes with generic branding and a basic UI, but relishes being customized with
your institution's flair. You should leverage the included
[Themes Library](https://github.com/tattersoftware/codeigniter4-themes) to add your own
themes or even replace the default theme (hint: `./spark themes:add`).

There are a number of places where branding can be changed centrally from the
[Preferences Library](https://github.com/tattersoftware/codeigniter4-preferences), and a built-in
CMS that allows for customized text in various places.

## Extending

**Bluesmith** is built off a handful of CodeIgniter 4 libraries that support modular loading.
This means it is easy to make your own extensions of existing features without deviating
from the master branch. Create your own directory with whatever modules you wish to extend
and add it to the list of autoloaded namespaces in **app/Config/Autoload.php**.

For the bold, jobs are processed through a series of modular actions that can be
added/changed/removed with the
[Workflows Library](https://github.com/tattersoftware/codeigniter4-workflows). 

Likewise, the included reports are all generated from modules that can be added to easily
via the [Reports Library](https://github.com/tattersoftware/codeigniter4-reports).

## Testing

**Bluesmith** comes bundled with its own unit tests. If you are planning on modifying or
extending the application you likely will want to run these tests or even add your own.
To run the tests...

1. Make sure you have `phpunit` installed (included automatically if you followed the Composer
installation above) and a code coverage

2. Install a code coverage driver like [Xdebug](http://xdebug.org)

3. Rename **phpunit.xml.dist** to **phpunit.xml** and modify the database settings to match your environment

4. Run the tests with the following command in the application root: `composer test`

5. Results are output to the CLI and in the **build/** directory
