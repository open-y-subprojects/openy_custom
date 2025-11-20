(function (Drupal, once) {
  "use strict";

  /**
   * This will scroll the page when the alert box appears.
   */
  Drupal.behaviors.openy_calc_errors = {
    attach: function (context, settings) {
      const alerts = context.querySelectorAll('.status-message__alert');
      const wrapper = document.getElementById('membership-calc-wrapper');

      if (alerts.length && wrapper) {
        const rect = wrapper.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const divPosition = rect.top + scrollTop;

        window.scrollTo({
          top: divPosition - 100,
          behavior: 'smooth'
        });

        alerts.forEach(function (alert) {
          alert.focus();
        });
      }
    }
  };
})(Drupal, once);
