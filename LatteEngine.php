<?php

require_once(dirname(__DIR__) . '/TemplateEngineFactory/TemplateEngine.php');
require_once(__DIR__ . '/TemplateEngineLatte.module');

/**
 * TemplateEngineLatte
 *
 * @author Richard Jedlička <jedlicka.r@gmail.com>
 * @license BSD
 * @version 1.0.0
 *
 * ProcessWire 2.x
 * Copyright (C) 2014 by Ryan Cramer
 * Licensed under GNU/GPL v2, see LICENSE.TXT
 *
 * http://processwire.com
 *
 */
class LatteEngine extends TemplateEngine
{
	const CACHE_DIR = 'TemplateEngineLatte_cache/';

	/**
	 * @var Latte
	 */
	protected $latte;

	/**
	 * @var array;
	 */
	protected $templateParams;

	/**
	 * Setup Smarty
	 *
	 */
	public function initEngine()
	{
		require_once(__DIR__ . '/latte/src/latte.php');

		$this->latte = new Latte\Engine();
		$this->latte->setTempDirectory($this->wire('config')->paths->assets . 'cache/' . self::CACHE_DIR);
	}

	/**
	 * Set a key/value pair to the template
	 *
	 * @param $key
	 * @param $value
	 */
	public function set($key, $value)
	{
		$this->templateParams[$key] = $value;
	}

	/**
	 * Render markup from template file
	 *
	 * @throws WireException
	 * @return mixed
	 */
	public function render()
	{
		try {
			return $this->latte->renderToString(
				$this->getTemplatesPath() . $this->getFilename(),
				$this->templateParams
			);
		} catch (Exception $e) {
			throw new WireException($e->getMessage());
		}
	}

	public function unistall()
	{
		parent::uninstall();

		wireRmdir($this->wire('config')->paths->assets . 'cache/' . self::CACHE_DIR, true);
	}
}