<?php

namespace Drupal\commerce_shopping_hours;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class CommerceShoppingHoursService.
 *
 * @package Drupal\commerce_shopping_hours
 */
class CommerceShoppingHoursService implements CommerceShoppingHoursServiceInterface {

  /**
   * The config.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * Constructor.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory->get('commerce_shopping_hours.settings');
  }

  /**
   * Check to see if functionality is enabled.
   */
  public function isEnabled() {
    $config = $this->config->get();
    return $config['enable'];
  }

  /**
   * Check to see if shop is open.
   */
  public function isShopOpen() {
    $config = $this->config->get();
    $today = strtolower(date('l'));
    $now = date('H:i');
    $now_ts = strtotime($now);
    $today_settings_from = $config[$today . '_from'];
    $today_settings_from_ts = strtotime($today_settings_from);
    $today_settings_to = $config[$today . '_to'];
    $today_settings_to_ts = strtotime($today_settings_to);

    if (empty($today_settings_from) || empty($today_settings_to)) {
      return FALSE;
    }
    if ($now_ts >= $today_settings_from_ts && $now_ts <= $today_settings_to_ts) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Get shopping hours.
   */
  public function getShoppingHours() {
    $config = $this->config->get();
    $today = strtolower(date('l'));
    $today_settings_from = $config[$today . '_from'];
    $today_settings_to = $config[$today . '_to'];
    return [
      'from' => $today_settings_from,
      'to' => $today_settings_to,
    ];
  }

}
