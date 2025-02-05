import { initRepeaterTabs } from './modules/repeater-tabs.js';
import { initCommandPalette } from './modules/command-palette/index.js';

document.addEventListener('DOMContentLoaded', function() {
  initRepeaterTabs();
  initCommandPalette();

  if (typeof acf !== 'undefined') {
    acf.addAction('append', function($el) {
      if ($el.hasClass('acf-row')) {
        initRepeaterTabs();
      }
    });

    acf.addAction('remove', function($el) {
      if ($el.hasClass('acf-row')) {
        initRepeaterTabs();
      }
    });
  }
});
