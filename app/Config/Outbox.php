<?php namespace Config;

use Tatter\Outbox\Config\Outbox as OutboxConfig;

class Outbox extends OutboxConfig
{
	/**
	 * Whether to include routes to the Templates Controller.
	 *
	 * @var boolean
	 */
	public $routeTemplates = true;

	/**
	 * Layout to use for template management.
	 *
	 * @var string
	 */
	public $layout = 'layouts/manage';

	/**
	 * Default CSS style view to apply to the template.
	 *
	 * @var string
	 */
	public $styles = 'emails/styles';
}
