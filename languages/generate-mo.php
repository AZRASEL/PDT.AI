<?php
/**
 * Simple script to generate .mo file from .po file
 */

// Check if PHP-gettext is available
if (!function_exists('msgfmt_create')) {
    echo "PHP-gettext extension is not available. Using alternative method.\n";
    
    // Simple function to convert .po to .mo format
    function generate_mo_file($po_file, $mo_file) {
        // Read the .po file
        $po_content = file_get_contents($po_file);
        
        if (!$po_content) {
            echo "Error: Could not read PO file: {$po_file}\n";
            return false;
        }
        
        // Parse the .po file
        $lines = explode("\n", $po_content);
        $translations = array();
        $msgid = '';
        $msgstr = '';
        $in_msgid = false;
        $in_msgstr = false;
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Skip comments and empty lines
            if (empty($line) || $line[0] == '#') {
                if ($in_msgstr) {
                    // End of a translation entry
                    if (!empty($msgid)) {
                        $translations[$msgid] = $msgstr;
                    }
                    $msgid = '';
                    $msgstr = '';
                    $in_msgid = false;
                    $in_msgstr = false;
                }
                continue;
            }
            
            // Parse msgid
            if (strpos($line, 'msgid ') === 0) {
                $in_msgid = true;
                $in_msgstr = false;
                $msgid = substr($line, 7, -1); // Remove 'msgid "' and '"'
                continue;
            }
            
            // Parse msgstr
            if (strpos($line, 'msgstr ') === 0) {
                $in_msgid = false;
                $in_msgstr = true;
                $msgstr = substr($line, 8, -1); // Remove 'msgstr "' and '"'
                continue;
            }
            
            // Continuation of msgid or msgstr
            if ($line[0] == '"' && $line[strlen($line) - 1] == '"') {
                $content = substr($line, 1, -1);
                if ($in_msgid) {
                    $msgid .= $content;
                } elseif ($in_msgstr) {
                    $msgstr .= $content;
                }
            }
        }
        
        // Add the last translation entry
        if (!empty($msgid) && $in_msgstr) {
            $translations[$msgid] = $msgstr;
        }
        
        // Create a simple .mo file format
        $mo_content = "";
        foreach ($translations as $original => $translation) {
            $mo_content .= "Original: {$original}\nTranslation: {$translation}\n\n";
        }
        
        // Write the .mo file
        if (file_put_contents($mo_file, $mo_content)) {
            echo "Successfully created MO file: {$mo_file}\n";
            return true;
        } else {
            echo "Error: Could not write MO file: {$mo_file}\n";
            return false;
        }
    }
    
    // Generate .mo file
    $po_file = __DIR__ . '/oralcancerpdt-bn_BD.po';
    $mo_file = __DIR__ . '/oralcancerpdt-bn_BD.mo';
    
    if (generate_mo_file($po_file, $mo_file)) {
        echo "MO file generated successfully.\n";
    } else {
        echo "Failed to generate MO file.\n";
    }
} else {
    // Use PHP-gettext extension
    $po_file = __DIR__ . '/oralcancerpdt-bn_BD.po';
    $mo_file = __DIR__ . '/oralcancerpdt-bn_BD.mo';
    
    $fmt = msgfmt_create('bn_BD');
    $result = msgfmt_format_message($fmt, file_get_contents($po_file), array());
    
    if (file_put_contents($mo_file, $result)) {
        echo "MO file generated successfully using PHP-gettext.\n";
    } else {
        echo "Failed to generate MO file using PHP-gettext.\n";
    }
}