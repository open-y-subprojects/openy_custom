<?php

namespace Drupal\openy_xdt\EventSubscriber;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Drupal\Core\Url;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Openy Cross-domain Tracking (XDT) event subscriber.
 */
class OpenyXdtSubscriber implements EventSubscriberInterface {

  /**
   * Kernel response event handler.
   *
   * @param ResponseEvent $event
   *   Response event.
   */
  public function onKernelResponse(ResponseEvent $event) {
    // Grab a cookie to decorate the response url.
    if ($event->getResponse() instanceof TrustedRedirectResponse) {
      // @todo Move both of these to config.
      $cookies = ['_ga', '_gl'];
      $domains = [];

      /* @var $response TrustedRedirectResponse */
      $response = $event->getResponse();
      $url = $response->getTargetUrl();

      // First decompose the URL into its parts as there may be existing queries.
      $parts = UrlHelper::parse($url);

      // If domains are specified AND do not match the url, do nothing.
      if (!empty($domains) && !in_array(parse_url($parts['path'], PHP_URL_HOST), $domains)) {
        return;
      }

      // If there is no domain specified, OR if the domain matches the url host,
      // then merge any additional cookies into the query.
      foreach ($cookies as $cookie) {
        if (isset($_COOKIE[$cookie])) {
          $parts['query'][$cookie] = Xss::filter($_COOKIE[$cookie]);
        }
      }

      // Finally recompose the URL and convert it back to a string.
      $newUrl = Url::fromUri($parts['path'], [
        'query' => $parts['query'],
        'fragment' => $parts['fragment']
      ])->toString();

      $response->setTrustedTargetUrl($newUrl);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => ['onKernelResponse'],
    ];
  }

}
