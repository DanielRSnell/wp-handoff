<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

class HandoffCLI {
    private $templates_dir;
    private $views_dir;
    
    // ANSI color codes
    private $colors = [
        'reset' => "\033[0m",
        'green' => "\033[32m",
        'blue' => "\033[34m",
        'yellow' => "\033[33m",
        'cyan' => "\033[36m",
        'white' => "\033[37m",
    ];

    public function __construct() {
        $this->templates_dir = __DIR__ . '/templates';
        $this->views_dir = __DIR__ . '/../src/views';
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
            case 'view':
                $this->createView($name);
                break;
            default:
                echo "❌ Template type not implemented: {$type}\n";
                exit(1);
        }
    }

    private function createView($name) {
        $name = $this->formatName($name);
        $lowercase_name = strtolower($name);
        $target_dir = $this->views_dir . '/' . $lowercase_name;

        if (is_dir($target_dir)) {
            echo "❌ " . $this->colorize("View already exists: {$name}", 'yellow') . "\n";
            exit(1);
        }

        echo "\n🚀 " . $this->colorize("Creating new view component: ", 'cyan') . $this->colorize($name, 'white') . "\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

        // Create target directory
        mkdir($target_dir, 0755, true);

        // Copy entire template directory structure
        $this->copyTemplateDirectory(
            $this->templates_dir . '/view',
            $target_dir,
            ['{{name}}' => $name, '{{lowercase_name}}' => $lowercase_name]
        );

        echo "\n✨ " . $this->colorize("Success! Component created successfully!", 'green') . "\n";
        echo "📁 Location: " . $this->colorize("src/views/{$lowercase_name}", 'blue') . "\n\n";
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

    private function formatName($name) {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $name)));
    }

    private function processTemplate($source, $target, $replacements) {
        $content = file_get_contents($source);
        $content = str_replace(array_keys($replacements), array_values($replacements), $content);
        file_put_contents($target, $content);
    }
}
