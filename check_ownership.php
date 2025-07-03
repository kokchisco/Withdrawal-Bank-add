<?php
$log_file = 'detailed_ownership_log.txt';
$log = "Detailed Ownership Check - " . date('Y-m-d H:i:s') . "\n";
$file = '/home/alutotra/domains/betall.it.com/public_html/ktrx5.php';
$directory = '/home/alutotra/domains/betall.it.com/public_html';

// File details
$log .= "\nChecking file: $file\n";
if (file_exists($file)) {
    $perms = sprintf("%o", fileperms($file) & 0777);
        $owner_id = fileowner($file);
            $group_id = filegroup($file);
                $owner = function_exists('posix_getpwuid') ? posix_getpwuid($owner_id)['name'] ?? 'Unknown' : 'POSIX disabled';
                    $group = function_exists('posix_getgrgid') ? posix_getgrgid($group_id)['name'] ?? 'Unknown' : 'POSIX disabled';
                        $is_readable = is_readable($file) ? 'Yes' : 'No';
                            $is_writable = is_writable($file) ? 'Yes' : 'No';
                                $log .= "Permissions: $perms\nOwner ID: $owner_id\nOwner Name: $owner\nGroup ID: $group_id\nGroup Name: $group\nReadable: $is_readable\nWritable: $is_writable\n";
                                } else {
                                    $log .= "File does not exist or is inaccessible\n";
                                    }

                                    // Directory details
                                    $log .= "\nChecking directory: $directory\n";
                                    if (file_exists($directory)) {
                                        $perms = sprintf("%o", fileperms($directory) & 0777);
                                            $owner_id = fileowner($directory);
                                                $group_id = filegroup($directory);
                                                    $owner = function_exists('posix_getpwuid') ? posix_getpwuid($owner_id)['name'] ?? 'Unknown' : 'POSIX disabled';
                                                        $group = function_exists('posix_getgrgid') ? posix_getgrgid($group_id)['name'] ?? 'Unknown' : 'POSIX disabled';
                                                            $is_readable = is_readable($directory) ? 'Yes' : 'No';
                                                                $is_writable = is_writable($directory) ? 'Yes' : 'No';
                                                                    $log .= "Permissions: $perms\nOwner ID: $owner_id\nOwner Name: $owner\nGroup ID: $group_id\nGroup Name: $group\nReadable: $is_readable\nWritable: $is_writable\n";
                                                                    } else {
                                                                        $log .= "Directory does not exist or is inaccessible\n";
                                                                        }

                                                                        // PHP environment
                                                                        $log .= "\nPHP Environment:\n";
                                                                        $log .= "Current User: " . (get_current_user() ?: 'Unknown') . "\n";
                                                                        $log .= "open_basedir: " . (ini_get('open_basedir') ?: 'None') . "\n";

                                                                        // Test CLI execution
                                                                        $php_path = exec('which php') ?: '/usr/local/bin/php';
                                                                        $log .= "\nTesting CLI execution of $file:\n";
                                                                        try {
                                                                            $output = shell_exec("$php_path $file 2>&1");
                                                                                $log .= "PHP Path: $php_path\nOutput: " . ($output ?: 'None') . "\n";
                                                                                } catch (Exception $e) {
                                                                                    $log .= "Error: " . $e->getMessage() . "\n";
                                                                                    }

                                                                                    file_put_contents($log_file, $log);
                                                                                    echo nl2br(htmlspecialchars($log));
                                                                                    ?>