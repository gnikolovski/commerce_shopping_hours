<?php

namespace Drupal\commerce_shopping_hours\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\commerce_shopping_hours\CommerceShoppingHoursService;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Provides a 'CommerceShoppingHoursBlock' block.
 *
 * @Block(
 *  id = "commerce_shopping_hours_block",
 *  admin_label = @Translation("Commerce shopping hours"),
 *  category = @Translation("Commerce")
 * )
 */
class CommerceShoppingHoursBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $config_factory;

  /**
   * Drupal\commerce_shopping_hours\CommerceShoppingHoursService definition.
   *
   * @var Drupal\commerce_shopping_hours\CommerceShoppingHoursService
   */
  protected $commerce_shopping_hours_service;

  /**
   * Construct.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        ConfigFactory $config_factory,
        CommerceShoppingHoursService $commerce_shopping_hours_service
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->config_factory = $config_factory;
    $this->commerce_shopping_hours_service = $commerce_shopping_hours_service;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('commerce_shopping_hours.commerce_shopping_hours_service')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $is_shop_open = $this->commerce_shopping_hours_service->isShopOpen();
    $shopping_hours = $this->commerce_shopping_hours_service->getShoppingHours();
    $config = $this->config_factory->get('commerce_shopping_hours.settings');
    $message = $config->get('message');
    $show_shopping_hours = $config->get('show_shopping_hours');

    $build[] = array(
      '#theme' => 'commerce_shopping_hours',
        '#is_open' => $is_shop_open,
        '#message' => t($message),
        '#shopping_hours' => $shopping_hours,
        '#show_shopping_hours' => $show_shopping_hours,
        '#cache' => array('max-age' => 0),
        '#attached' => array('library' => array('commerce_shopping_hours/commerce_shopping_hours')),
    );

    return $build;
  }

}
