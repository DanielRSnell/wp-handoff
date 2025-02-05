import { initRepeaterTabs } from './modules/repeater-tabs.js';
import { initCommandPalette } from './modules/command-palette/index.js';
import { initFlexibleManager } from './modules/flexible-manager.js';

document.addEventListener('DOMContentLoaded', function() {
  const flexibleManager = initFlexibleManager();
  initRepeaterTabs();
  initCommandPalette();

  if (typeof acf !== 'undefined') {
    acf.addAction('append', function($el) {
      if ($el.hasClass('acf-row')) {
        initRepeaterTabs();
      }
      // Refresh flexible manager when content changes
      flexibleManager.refresh();
    });

    acf.addAction('remove', function($el) {
      if ($el.hasClass('acf-row')) {
        initRepeaterTabs();
      }
      // Refresh flexible manager when content changes
      flexibleManager.refresh();
    });

    // Handle sortstop event for when layouts are reordered
    acf.addAction('sortstop', function($el) {
      if ($el.hasClass('values')) {
        flexibleManager.refresh();
      }
    });
  }
});
