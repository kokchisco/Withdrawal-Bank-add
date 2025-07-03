<?php
// cron_manager.php
// URL-based cron manager for betall.it.com
// Credit: Adapted from https://t.me/youtubegyrox

// Function to run a URL via curl
function run_url($url) {
    $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Adjust if SSL issues
                    curl_exec($ch);
                        curl_close($ch);
                        }

                        // Base URL
                        $base_url = 'https://betall.it.com';

                        // Scripts to run
                        $scripts = [
                            'every_minute' => [
                                    'niyamitakelasa_zehn.php',
                                            'niyamitakelasa.php',
                                                    'niyamitakelasa_aidudi.php',
                                                            'niyamitakelasa_kemuru.php',
                                                                    'ktrx.php'
                                                                        ],
                                                                            'every_3_minutes' => [
                                                                                    'niyamitakelasa_drei.php',
                                                                                            'niyamitakelasa_aidudi_drei.php',
                                                                                                    'niyamitakelasa_kemuru_drei.php',
                                                                                                            'ktrx3.php'
                                                                                                                ],
                                                                                                                    'every_5_minutes' => [
                                                                                                                            'niyamitakelasa_funf.php',
                                                                                                                                    'niyamitakelasa_aidudi_funf.php',
                                                                                                                                            'niyamitakelasa_kemuru_funf.php',
                                                                                                                                                    'ktrx5.php'
                                                                                                                                                        ],
                                                                                                                                                            'every_10_minutes' => [
                                                                                                                                                                    'niyamitakelasa_aidudi_zehn.php',
                                                                                                                                                                            'niyamitakelasa_kemuru_zehn.php',
                                                                                                                                                                                    'ktrx10.php'
                                                                                                                                                                                        ]
                                                                                                                                                                                        ];

                                                                                                                                                                                        // Get current minute
                                                                                                                                                                                        $minute = (int) date('i');

                                                                                                                                                                                        // Run scripts based on schedule
                                                                                                                                                                                        // Every minute
                                                                                                                                                                                        foreach ($scripts['every_minute'] as $script) {
                                                                                                                                                                                            run_url("$base_url/$script");
                                                                                                                                                                                            }

                                                                                                                                                                                            // Every 3 minutes
                                                                                                                                                                                            if ($minute % 3 === 0) {
                                                                                                                                                                                                foreach ($scripts['every_3_minutes'] as $script) {
                                                                                                                                                                                                        run_url("$base_url/$script");
                                                                                                                                                                                                            }
                                                                                                                                                                                                            }

                                                                                                                                                                                                            // Every 5 minutes
                                                                                                                                                                                                            if ($minute % 5 === 0) {
                                                                                                                                                                                                                foreach ($scripts['every_5_minutes'] as $script) {
                                                                                                                                                                                                                        run_url("$base_url/$script");
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                            }

                                                                                                                                                                                                                            // Every 10 minutes
                                                                                                                                                                                                                            if ($minute % 10 === 0) {
                                                                                                                                                                                                                                foreach ($scripts['every_10_minutes'] as $script) {
                                                                                                                                                                                                                                        run_url("$base_url/$script");
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                            // Handle 30-second interval for niyamitakelasa_zehn.php
                                                                                                                                                                                                                                            run_url("$base_url/niyamitakelasa_zehn.php");
                                                                                                                                                                                                                                            sleep(30);
                                                                                                                                                                                                                                            run_url("$base_url/niyamitakelasa_zehn.php");

                                                                                                                                                                                                                                            exit;