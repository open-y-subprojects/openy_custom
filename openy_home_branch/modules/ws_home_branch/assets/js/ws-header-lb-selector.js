/**
 * @file
 * Location finder extension with Home Branch logic.
 */

(function ($, Drupal, drupalSettings) {

  "use strict";

  /**
   * Add plugin, that related to Location Finder.
   */
  Drupal.homeBranch.plugins.push({
    name: 'hb-selector--link',
    attach: function (settings, context) {
      // Set top position for select branch link on mobile screen.
      $('.hb-selector--link').hbPlugin(settings);
      const header = $('.ws-header', context);
      if (header.hasClass('mobile')) {
        const positionOffset = 5;
        const mobileHeaderHeight = $('.header--top').outerHeight() + $('.header--bottom').outerHeight() + positionOffset;
        $('.hb-selector').css('top', mobileHeaderHeight + 'px');
      }
    },
    settings: {
      selector: '.hb-selector--link',
      event: 'click',
      element: null,
      targetSelector: drupalSettings.home_branch.hb_header_lb_selector.targetSelector,
      defaultTitle: drupalSettings.home_branch.hb_header_lb_selector.defaultTitle,
      init: function () {
        if (!this.element) {
          return;
        }
        let selected = Drupal.homeBranch.getValue('id');
        let locations = Drupal.homeBranch.getLocations();
        if (selected) {
          this.element.text(locations[selected]);
        }
        else {
          this.element.text(this.defaultTitle);
        }
      },
      onChange: function (event, el) {
        let selected = Drupal.homeBranch.getValue('id');
        if (!selected) {
          // Show HB locations modal.
          Drupal.homeBranch.showModal(true);
        }
        else {
          // Redirect to branch page.
          location.href = drupalSettings.path.baseUrl + 'node/' + selected;
        }
      },
      addMarkup: function (context) {
        let block = $(this.targetSelector);
        block.append('<span class="hb-selector"><i class="fas fa-map-marker-alt"></i><a class="hb-selector--link" href="#">' + this.defaultTitle + '</a></span>');
        // Save created element in plugin.
        this.element = $(this.selector, block);
      }
    }
  });
})(jQuery, Drupal, drupalSettings);
