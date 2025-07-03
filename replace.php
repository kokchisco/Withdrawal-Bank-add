<?php
// Configuration
$directory = '/home/alutotra/domains/betall.it.com/public_html'; // Replace with your directory path
$search = 'Asia/Kolkata'; // Search for this text
$replace = 'Asia/Kolkata'; // Replace with this text
$extensions = ['php', 'html', 'js', 'css', 'txt']; // File extensions to process
$log_file = 'replace_log.txt'; // Log file to track changes

// Initialize log
$log = "Search and Replace Log - " . date('Y-m-d H:i:s') . "\n";
$log .= "Searching for: '$search'\nReplacing with: '$replace'\n\n";

// Function to check if file extension is allowed
function is_allowed_extension($file, $extensions) {
    return in_array(strtolower($file->getExtension()), array_map('strtolower', $extensions));
}

// Function to process files recursively
function search_and_replace($directory, $search, $replace, $extensions, &$log) {
    try {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $modified_files = 0;
        $skipped_files = 0;

        foreach ($iterator as $file) {
            if ($file->isFile() && is_allowed_extension($file, $extensions)) {
                $file_path = $file->getPathname();
                
                // Check if file is readable and writable
                if (!is_readable($file_path) || !is_writable($file_path)) {
                    $log .= "Skipped (permission issue): $file_path\n";
                    $skipped_files++;
                    continue;
                }

                // Read file content
                $content = file_get_contents($file_path);
                if ($content === false) {
                    $log .= "Skipped (read error): $file_path\n";
                    $skipped_files++;
                    continue;
                }

                // Perform replacement
                $new_content = str_replace($search, $replace, $content, $count);

                // If changes were made, write back to file
                if ($count > 0) {
                    if (file_put_contents($file_path, $new_content) !== false) {
                        $log .= "Modified ($count replacements): $file_path\n";
                        $modified_files++;
                    } else {
                        $log .= "Skipped (write error): $file_path\n";
                        $skipped_files++;
                    }
                }
            }
        }

        $log .= "\nSummary: $modified_files files modified, $skipped_files files skipped.\n";
    } catch (Exception $e) {
        $log .= "Error: " . $e->getMessage() . "\n";
    }

    return $log;
}

// Execute the search and replace
$log .= search_and_replace($directory, $search, $replace, $extensions, $log);

// Save log to file
file_put_contents($log_file, $log);

// Output results to browser
echo nl2br(htmlspecialchars($log));
?>