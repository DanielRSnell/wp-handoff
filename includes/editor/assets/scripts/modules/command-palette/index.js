import { CommandPaletteWindow } from './window.js';
import { CommandPaletteCommands } from './commands.js';

let commandPalette;

export function initCommandPalette() {
  window.handoff = window.handoff || {};

  const registerLayoutHandler = () => {
    const fields = window.acf.getFields();
    
    if (!fields || !Array.isArray(fields)) return;

    const componentsField = fields.find(field => 
      field.data && field.data.name === 'components'
    );

    if (!componentsField) return;

    const fieldKey = componentsField.get('key');

    window.handoff.addLayout = (layoutName) => {
      const field = window.acf.getField(fieldKey);
      if (field) {
        field.add({ layout: layoutName });
      }
    };
  };

  commandPalette = new CommandPaletteWindow();
  window.CommandPalette = CommandPaletteCommands.init(commandPalette);

  if (typeof acf !== 'undefined') {
    acf.addAction('show_field_popup', function(popup, $el) {
      if ($el.hasClass('acf-fc-add')) {
        registerLayoutHandler();
        window.CommandPalette.open();
        return false;
      }
    }, 5);
  }

  document.addEventListener('click', (e) => {
    const button = e.target.closest('[data-name="add-layout"]');
    if (button) {
      e.preventDefault();
      e.stopPropagation();
      registerLayoutHandler();
      window.CommandPalette.open();
    }
  });

  document.addEventListener('keydown', (e) => {
    if ((e.key === 'k' || e.key === 'K') && (e.metaKey || e.ctrlKey) && !e.shiftKey && !e.altKey) {
      e.preventDefault();
      registerLayoutHandler();
      window.CommandPalette.open();
    }
  });
}
