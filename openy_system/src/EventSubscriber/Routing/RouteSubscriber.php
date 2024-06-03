<?php

namespace Drupal\openy_system\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Modify core routes to support redirect.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // See https://www.drupal.org/project/redirect/issues/3373123 .
    if ($route = $collection->get('system.js_asset')) {
      $route->setDefault('_disable_route_normalizer', TRUE);
    }
    if ($route = $collection->get('system.css_asset')) {
      $route->setDefault('_disable_route_normalizer', TRUE);
    }
  }

}
