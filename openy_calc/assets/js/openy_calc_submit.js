/**
 * Functions for after the form has been submitted.
 */
(function (Drupal, once) {
  "use strict";

  /**
   * This will scroll the page up after the first step.
   */
  Drupal.behaviors.openy_calc_scroll = {
    attach: function (context, settings) {
      once('openy-calc-scroll', '#membership-calc-wrapper', context).forEach((wrapper) => {
        const rect = wrapper.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const divPosition = rect.top + scrollTop;

        window.scrollTo({
          top: divPosition - 100,
          behavior: 'smooth'
        });
      });
    }
  };

  /**
   * This will focus current tab for aria.
   */
  Drupal.behaviors.openy_calc_focus = {
    attach: function (context, settings) {
      //After ajax response rendered input[name="step-3"] button is focused, we need to wait for that.

      const nextButton = document.querySelector('input[name="step-3"]');
      const activeTab = document.querySelector('a[role="tab"][aria-selected="true"]');

      if (nextButton) {
        nextButton.addEventListener('focus', function () {
          if (activeTab) {
            activeTab.focus();
          }
        });
      } else if (activeTab) {
        activeTab.focus();
      }
    }
  };
})(Drupal, once);
