<?php

namespace Drupal\Tests\systemseed_assessment\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Verify that the configured defaults load as intended.
 *
 * @group systemseed_assessment
 */
class HealthCheckTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['systemseed_assessment'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'bartik';

  /**
   * Tests that the admin works.
   */
  public function testHomepageOpens() {
    $this->drupalGet('');
    $this->assertSession()->statusCodeEquals(200);
  }

}
