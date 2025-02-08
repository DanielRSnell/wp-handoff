<?php
namespace Umbral\Editor\Handlers;

class SaveHandler extends BaseHandler {
    public function handleSave() {
        check_ajax_referer('wp_handoff_editor', 'nonce');

        $post_id = intval($_POST['post_id']);
        if (!current_user_can('edit_post', $post_id)) {
            wp_send_json_error(['message' => 'Permission denied']);
        }

        $fields = $_POST['fields'] ?? [];
        foreach ($fields as $key => $value) {
            update_field($key, $value, $post_id);
        }

        wp_send_json_success([
            'message' => 'Changes saved successfully',
            'redirect' => add_query_arg('editor', 'true', $this->editor->getReturnUrl())
        ]);
    }
}
