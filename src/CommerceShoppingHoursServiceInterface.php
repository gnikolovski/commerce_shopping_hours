<?php

namespace Drupal\commerce_shopping_hours;

/**
 * Interface CommerceShoppingHoursServiceInterface.
 *
 * @package Drupal\commerce_shopping_hours
 */
interface CommerceShoppingHoursServiceInterface {

  public function isShopOpen();
  public function getShoppingHours();

}
