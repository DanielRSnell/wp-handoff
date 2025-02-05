// TODO: Make it so only one panel can be open at a time for a focused non-confusing editing experience.
export function initFlexibleManager() {
  return;
  document.addEventListener('click', (e) => {
    const collapseButton = e.target.closest('[data-name="collapse-layout"]');
    if (!collapseButton) return;

    e.preventDefault();
    const currentLayout = collapseButton.closest('.layout');
    if (!currentLayout) return;

    // If clicking an already collapsed layout
    if (currentLayout.classList.contains('-collapsed')) {
      // First collapse all layouts and reset their toggle buttons
      document.querySelectorAll('.layout').forEach(layout => {
        layout.classList.add('-collapsed');
        const toggleBtn = layout.querySelector('[data-name="collapse-layout"]');
        if (toggleBtn) {
          toggleBtn.classList.remove('-clear');
        }
      });
      
      // Then expand current one and update its toggle
      currentLayout.classList.remove('-collapsed');
      collapseButton.classList.add('-clear');
    } else {
      // If layout is expanded, collapse it and update toggle
      currentLayout.classList.add('-collapsed');
      collapseButton.classList.remove('-clear');
    }
  });

  // Handle new layouts
  if (typeof acf !== 'undefined') {
    acf.addAction('append', ($el) => {
      if ($el.hasClass('layout')) {
        // Collapse all other layouts and reset their toggles
        document.querySelectorAll('.layout').forEach(layout => {
          if (layout !== $el[0]) {
            layout.classList.add('-collapsed');
            const toggleBtn = layout.querySelector('[data-name="collapse-layout"]');
            if (toggleBtn) {
              toggleBtn.classList.remove('-clear');
            }
          }
        });
        
        // Set new layout's toggle state
        const newToggle = $el[0].querySelector('[data-name="collapse-layout"]');
        if (newToggle) {
          newToggle.classList.add('-clear');
        }
      }
    });
  }
}
