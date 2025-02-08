// (function($) {
//   if (typeof acf === 'undefined') return;

//   const LocationControls = {
//     init() {
//       console.log('LocationControls initialized');
      
//       // Handle initial state and changes to group field
//       this.bindGroupFieldEvents();
//       this.initExistingGroups();
//     },

//     bindGroupFieldEvents() {
//       // Listen for changes on group select fields
//       $(document).on('change', '[data-name="group"]', (e) => {
//         const $groupField = $(e.currentTarget);
//         const $row = $groupField.closest('.acf-row');
//         const $typeField = $row.find('[data-name="type"]').closest('.acf-field');
        
//         this.handleGroupVisibility($groupField.val(), $typeField);
//       });
//     },

//     initExistingGroups() {
//       // Handle initial state for all group fields
//       $('[data-name="group"]').each((_, groupField) => {
//         const $groupField = $(groupField);
//         const $row = $groupField.closest('.acf-row');
//         const $typeField = $row.find('[data-name="type"]').closest('.acf-field');
        
//         this.handleGroupVisibility($groupField.val(), $typeField);
//       });
//     },

//     handleGroupVisibility(groupValue, $typeField) {
//       console.log('Group value:', groupValue);
//       console.log('Type field:', $typeField);

//       if (['singular', 'archive', 'taxonomy'].includes(groupValue)) {
//         $typeField.show();
//       } else {
//         $typeField.hide();
//       }
//     }
//   };

//   // Initialize when ACF is ready
//   acf.addAction('ready', () => {
//     console.log('ACF Ready - Initializing LocationControls');
//     LocationControls.init();
//   });

// })(jQuery);
