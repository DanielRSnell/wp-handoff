(function($) {
    if (typeof acf === 'undefined' || typeof locationOptions === 'undefined') return;

    const LocationControls = {
        init() {
            this.bindEvents();
            this.initExistingFields();
        },

        bindEvents() {
            acf.addAction('append_field/name=location_rules', this.handleNewRow.bind(this));
            acf.addAction('ready_field/name=location_rules', this.initExistingFields.bind(this));
            acf.addAction('change', this.handleFieldChange.bind(this));
        },

        initExistingFields() {
            $('.acf-field-repeater[data-key="field_location_rules"] .acf-row').each((i, row) => {
                this.updateFields($(row));
            });
        },

        handleNewRow(field) {
            if (field.$el.is('.acf-field-repeater')) {
                const $row = field.$el.find('.acf-row:last');
                this.updateFields($row);
            }
        },

        handleFieldChange(field) {
            const $row = field.$el.closest('.acf-row');
            if (!$row.length) return;
            
            const fieldKey = field.get('key');
            
            switch (fieldKey) {
                case 'field_rule_group':
                    this.updateFields($row);
                    break;
                case 'field_rule_type':
                    this.updateModeAndItems($row);
                    break;
                case 'field_rule_mode':
                    this.handleModeChange($row);
                    break;
            }
        },

        updateFields($row) {
            const groupField = acf.getField($row.find('[data-key="field_rule_group"]'));
            const typeField = acf.getField($row.find('[data-key="field_rule_type"]'));
            const modeField = acf.getField($row.find('[data-key="field_rule_mode"]'));
            const itemsField = acf.getField($row.find('[data-key="field_rule_items"]'));
            
            if (!groupField || !typeField || !modeField || !itemsField) return;

            const group = groupField.val();
            
            // Hide all fields initially
            typeField.$el.hide();
            modeField.$el.hide();
            itemsField.$el.hide();

            // Show/hide fields based on group
            switch (group) {
                case 'singular':
                case 'archive':
                case 'taxonomy':
                    typeField.$el.show();
                    this.filterTypeOptions($row, group);
                    break;
                    
                case 'route':
                case 'hook':
                    // Custom input handling if needed
                    break;
            }
        },

        filterTypeOptions($row, group) {
            const typeField = acf.getField($row.find('[data-key="field_rule_type"]'));
            const currentValue = typeField.val();
            
            let choices = {};
            const prefix = group === 'taxonomy' ? 'taxonomy_' : 'post_type_';
            const archiveSuffix = group === 'archive' ? '_archive' : '';
            
            Object.entries(locationOptions.types).forEach(([key, label]) => {
                if (key.startsWith(prefix)) {
                    if (group === 'archive' && key.endsWith('_archive')) {
                        choices[key] = label;
                    } else if (group !== 'archive' && !key.endsWith('_archive')) {
                        choices[key] = label;
                    }
                }
            });

            typeField.set('choices', choices);

            if (currentValue && choices[currentValue]) {
                typeField.val(currentValue);
            }

            this.updateModeAndItems($row);
        },

        updateModeAndItems($row) {
            const groupField = acf.getField($row.find('[data-key="field_rule_group"]'));
            const typeField = acf.getField($row.find('[data-key="field_rule_type"]'));
            const modeField = acf.getField($row.find('[data-key="field_rule_mode"]'));
            
            const group = groupField.val();
            const type = typeField.val();

            if (group === 'singular' && type) {
                modeField.$el.show();
                this.handleModeChange($row);
            }
        },

        handleModeChange($row) {
            const modeField = acf.getField($row.find('[data-key="field_rule_mode"]'));
            const itemsField = acf.getField($row.find('[data-key="field_rule_items"]'));
            
            if (modeField.val() === 'all') {
                itemsField.$el.hide();
            } else {
                this.filterItemOptions($row);
                itemsField.$el.show();
            }
        },

        filterItemOptions($row) {
            const typeField = acf.getField($row.find('[data-key="field_rule_type"]'));
            const itemsField = acf.getField($row.find('[data-key="field_rule_items"]'));
            
            const type = typeField.val();
            const currentValues = itemsField.val() || [];
            
            let choices = {};
            const typePrefix = type.replace('post_type_', '').replace('taxonomy_', '');

            Object.entries(locationOptions.items).forEach(([key, item]) => {
                if (key.startsWith(typePrefix)) {
                    choices[item.id] = item.title;
                }
            });

            itemsField.set('choices', choices);

            const validValues = currentValues.filter(value => 
                Object.keys(choices).includes(value.toString())
            );
            
            if (validValues.length) {
                itemsField.val(validValues);
            }
        }
    };

    LocationControls.init();
})(jQuery);
