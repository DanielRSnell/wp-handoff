<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

class HandoffCLI {
    private $templates_dir;
    private $colors;
    private $originalName;
    
    public function __construct() {
        $this->templates_dir = __DIR__ . '/templates';
        $this->colors = [
            'reset' => "\033[0m",
            'green' => "\033[32m",
            'blue' => "\033[34m",
            'yellow' => "\033[33m",
            'cyan' => "\033[36m",
            'white' => "\033[37m",
        ];
    }

    private function colorize($text, $color) {
        return $this->colors[$color] . $text . $this->colors['reset'];
    }

    public function create($type, $name) {
        $template_dir = $this->templates_dir . '/' . $type;
        
        if (!is_dir($template_dir)) {
            echo "❌ Unknown type: {$type}\n";
            exit(1);
        }

        switch ($type) {
            case 'block':
                $this->createBlock($name);
                break;
            case 'options':
                $this->createOptions($name);
                break;
            case 'post-type':
                $this->createPostType($name);
                break;
            case 'taxonomy':
                $this->createTaxonomy($name);
                break;
            case 'view':
                $this->createView($name);
                break;
            default:
                echo "❌ Template type not implemented: {$type}\n";
                exit(1);
        }
    }

    private function createBlock($name) {
        $this->originalName = $name;
        $formatted_name = $this->formatName($name);
        $directory_name = $this->formatDirectoryName($name);
        $target_dir = dirname(__DIR__) . '/src/blocks/' . $directory_name;

        if (is_dir($target_dir)) {
            echo "❌ " . $this->colorize("Block already exists: {$formatted_name}", 'yellow') . "\n";
            exit(1);
        }

        $this->createComponent('block', $formatted_name, $target_dir);
    }

    private function createOptions($name) {
        $this->originalName = $name;
        $formatted_name = $this->formatName($name);
        $directory_name = $this->formatDirectoryName($name);
        $target_dir = dirname(__DIR__) . '/src/register/options/' . $directory_name;

        if (is_dir($target_dir)) {
            echo "❌ " . $this->colorize("Options page already exists: {$formatted_name}", 'yellow') . "\n";
            exit(1);
        }

        $this->createComponent('options', $formatted_name, $target_dir);
    }

    private function createPostType($name) {
        $this->originalName = $name;
        $formatted_name = $this->formatName($name);
        $directory_name = $this->formatDirectoryName($name);
        $target_dir = dirname(__DIR__) . '/src/register/post-type/' . $directory_name;

        if (is_dir($target_dir)) {
            echo "❌ " . $this->colorize("Post type already exists: {$formatted_name}", 'yellow') . "\n";
            exit(1);
        }

        $this->createComponent('post-type', $formatted_name, $target_dir);
    }

    private function createTaxonomy($name) {
        $this->originalName = $name;
        $formatted_name = $this->formatName($name);
        $directory_name = $this->formatDirectoryName($name);
        $target_dir = dirname(__DIR__) . '/src/register/taxonomy/' . $directory_name;

        if (is_dir($target_dir)) {
            echo "❌ " . $this->colorize("Taxonomy already exists: {$formatted_name}", 'yellow') . "\n";
            exit(1);
        }

        $this->createComponent('taxonomy', $formatted_name, $target_dir);
    }

    private function createView($name) {
        $this->originalName = $name;
        $formatted_name = $this->formatName($name);
        $directory_name = $this->formatDirectoryName($name);
        $target_dir = dirname(__DIR__) . '/src/views/' . $directory_name;

        if (is_dir($target_dir)) {
            echo "❌ " . $this->colorize("View already exists: {$formatted_name}", 'yellow') . "\n";
            exit(1);
        }

        $this->createComponent('view', $formatted_name, $target_dir);
    }

    private function createComponent($type, $name, $target_dir) {
        echo "\n🚀 " . $this->colorize("Creating new {$type}: ", 'cyan') . $this->colorize($name, 'white') . "\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

        mkdir($target_dir, 0755, true);

        if ($type === 'block') {
            mkdir($target_dir . '/components', 0755, true);
        }

        $this->copyTemplateDirectory(
            $this->templates_dir . '/' . $type,
            $target_dir,
            [
                '{{name}}' => $name,
                '{{menu_name}}' => $this->formatMenuName($this->originalName),
                '{{lowercase_name}}' => $this->formatDirectoryName($name),
                '{{plural_name}}' => $this->pluralize($this->originalName),
                '{{lowercase_plural_name}}' => $this->formatDirectoryName($this->pluralize($this->originalName))
            ]
        );

        echo "\n✨ " . $this->colorize("Success! {$type} created successfully!", 'green') . "\n";
        echo "📁 Location: " . $this->colorize("src/" . ($type === 'view' ? 'views' : ($type === 'block' ? 'blocks' : 'register/' . $type)) . "/{$this->formatDirectoryName($name)}", 'blue') . "\n\n";
    }

    private function copyTemplateDirectory($source, $dest, $replacements) {
        $dir = opendir($source);
        
        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..') {
                $sourcePath = $source . '/' . $file;
                $destPath = $dest . '/' . $file;
                
                if (is_dir($sourcePath)) {
                    mkdir($destPath, 0755, true);
                    $this->copyTemplateDirectory($sourcePath, $destPath, $replacements);
                } else {
                    echo "📝 Creating: " . $this->colorize(basename($destPath), 'white') . "\n";
                    $this->processTemplate($sourcePath, $destPath, $replacements);
                }
            }
        }
        
        closedir($dir);
    }

    private function processTemplate($source, $target, $replacements) {
        $content = file_get_contents($source);
        $content = str_replace(array_keys($replacements), array_values($replacements), $content);
        file_put_contents($target, $content);
    }

    private function formatName($name) {
        return str_replace(' ', '', ucwords($name));
    }

    private function formatMenuName($name) {
        return ucwords($name);
    }

    private function formatDirectoryName($name) {
        return strtolower(str_replace(' ', '-', $name));
    }

    private function pluralize($name) {
        $name = rtrim($name, 's');
        $last_char = strtolower($name[strlen($name)-1]);
        
        if ($last_char === 'y') {
            return substr($name, 0, -1) . 'ies';
        }
        
        if (in_array($last_char, ['s', 'x', 'z']) || 
            substr($name, -2) === 'ch' || 
            substr($name, -2) === 'sh') {
            return $name . 'es';
        }
        
        return $name . 's';
    }
}
