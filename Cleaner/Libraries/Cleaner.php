<?php

namespace Module\Cleaner\Libraries;

use App\Libraries\System\Events;

class Cleaner
{
    public static function clean() {
        self::cleanDirectories();
    }

    public static function cleanDirectories() {
        $directories = self::getCleanerDirectories();

        $count = [];

        // for each directory, delete all files that are older than 7 days
        foreach ($directories as $directory) {
            $files = glob($directory . '/*'); // get all file names
            foreach($files as $file){ // iterate files
                if(is_file($file) && filemtime($file) < time() - 7 * 86400) {
                    unlink($file); // delete file

                    if (!isset($count[$directory])) {
                        $count[$directory] = 0;
                    }

                    $count[$directory]++;
                }
            }
        }

        self::printCleanerDirectoryReceipt($count);
    }

    public static function getCleanerDirectories()
    {
        $directories = [
            WRITEPATH . 'logs',
            WRITEPATH . 'cleaner_receipts'
        ];

        return Events::fire('cleaner_get_directories', $directories);
    }

    public static function printCleanerDirectoryReceipt(array $count) {
        $print_directory = WRITEPATH . 'cleaner_receipts';

        if (!is_dir($print_directory)) {
            mkdir($print_directory);
        }

        $file = $print_directory . '/' . date('Y-m-d') . '.receipt.txt';

        $receipt = 'Cleaner Receipt - '.date("jS F Y, g:i a").PHP_EOL.PHP_EOL;

        foreach($count as $directory => $total) {
            $receipt .= $directory . ' - ' . $total . ' files deleted' . PHP_EOL;
        }

        file_put_contents($file, $receipt);
    }
}