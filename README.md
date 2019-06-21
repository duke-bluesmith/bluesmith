# Bluesmith

3D Print manager, Bluesmith (https://bluesmith.oit.duke.edu)

by Duke University OIT

(CodeIgniter 4 port of https://gitlab.oit.duke.edu/msg8/bluesmith)

## Setup

1. Clone or download the repository
2. In the root directory, copy **env** to **.env** and edit the new file:
	* Set `app.baseURL` to your site (with trailing slash), e.g. 'https://bluesmith.example.edu/'
	* Set all variables in the `DATABASE` section
3. Install all packages and dependencies with the following command in the root directory:
	* `composer update`<sup>1</sup>
4. Seed the database with the necessary initial settings:
	* `./spark tatter:publish`
	* `./spark tasks:register`
	* `./spark db:seed \\Tatter\\Themes\\Database\\Seeds\\ThemeSeeder`
5. Setup cron jobs for the following tasks
	* `./spark reports:generate`
6. Set your web server to serve the **public/** directory

	
<sup>1</sup> Note: This should trigger composer's post update commands which handle database migrations
and vendor assets, but if that fails or if you update manually be sure to run the following
additional commands from the root directory:
	* `./post-update.sh`
	* `./spark migrate:latest -all`


## Customize

Bluesmith comes with generic branding and a basic UI, but relishes being customized with
your institution's flair. You should leverage the included
[Themes Library](https://github.com/tattersoftware/codeigniter4-themes) to add your own
themes or even replace the default theme (hint: `./spark themes:add`).

There are a number of places where displayed names can be changed centrally from the
[Settings Library](https://github.com/tattersoftware/codeigniter4-settings), and a built-in
CMS that allows for customized text in various places.

## Extending

Bluesmith is built off a handful of CodeIgniter 4 libraries that support modular loading.
This means it is easy to make your own extensions of existing features without deviating
from the master branch. Create your own directory with whatever modules you wish to extend
and add it to the list of autoloaded namespaces in **app/Config/Autoload.php**.

For the bold, jobs are processed through a series of modular tasks that can be
added/changed/removed with the
[Workflows Library](https://github.com/tattersoftware/codeigniter4-workflows). 

Likewise, the included reports are all generated from modules that can be added to easily
via the [Reports Library](https://github.com/tattersoftware/codeigniter4-reports).
