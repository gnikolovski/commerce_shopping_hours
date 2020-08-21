<?php

namespace Drupal\Tests\commerce_shopping_hours\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests the settings form.
 *
 * @group commerce_shopping_hours
 */
class CommerceShoppingHoursFormTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'commerce_shopping_hours',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->drupalLogin($this->drupalCreateUser(['administer site configuration']));
  }

  /**
   * Tests the settings form structure.
   */
  public function testFormStructure() {
    $this->drupalGet('admin/commerce/config/commerce_shopping_hours');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->titleEquals('Shopping hours | Drupal');
    $this->assertSession()->fieldExists('edit-monday-from');
    $this->assertSession()->fieldExists('edit-monday-to');
    $this->assertSession()->fieldExists('edit-tuesday-from');
    $this->assertSession()->fieldExists('edit-tuesday-to');
    $this->assertSession()->fieldExists('edit-wednesday-from');
    $this->assertSession()->fieldExists('edit-wednesday-to');
    $this->assertSession()->fieldExists('edit-thursday-from');
    $this->assertSession()->fieldExists('edit-thursday-to');
    $this->assertSession()->fieldExists('edit-friday-from');
    $this->assertSession()->fieldExists('edit-friday-to');
    $this->assertSession()->fieldExists('edit-saturday-from');
    $this->assertSession()->fieldExists('edit-saturday-to');
    $this->assertSession()->fieldExists('edit-sunday-from');
    $this->assertSession()->fieldExists('edit-sunday-to');
    $this->assertSession()->fieldExists('edit-message');
    $this->assertSession()->checkboxChecked('edit-show-shopping-hours');
    $this->assertSession()->checkboxChecked('edit-enable');
    $this->assertSession()->buttonExists('Save configuration');
  }

  /**
   * Tests the settings form access.
   */
  public function testFormAccess() {
    $this->drupalLogout();
    $this->drupalGet('admin/commerce/config/commerce_shopping_hours');
    $this->assertSession()->statusCodeEquals(403);
  }

}
