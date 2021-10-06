<?php

namespace Captcha\Test\TestCase\Controller;

use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Form\Form;
use Cake\TestSuite\IntegrationTestCase;
use Captcha\Controller\Component\CaptchaComponent;

class CaptchaComponentTest extends IntegrationTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	protected $fixtures = [
		'plugin.Captcha.Captchas',
		'core.Sessions',
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		Configure::write('Captcha', []);
	}

	/**
	 * @return void
	 */
	public function testAddValidation() {
		$captchaComponent = new CaptchaComponent(new ComponentRegistry());

		$contactForm = new Form();

		$captchaComponent->addValidation($contactForm->getValidator());

		$this->assertFalse($contactForm->execute([]));
	}

}
