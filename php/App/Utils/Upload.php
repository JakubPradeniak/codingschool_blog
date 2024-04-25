<?php

declare(strict_types=1);

namespace App\Utils;

class Upload
{
    public static function image(
        string $storeTo = 'Resources/Images/',
        string $inputName = 'image'
    ): string|null {
        if (isset($_FILES[$inputName]) && strpos($_FILES[$inputName]['type'], 'image') !== false) {
            $storeFileName = $storeTo . $_FILES[$inputName]['name'];
            if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/' . $storeFileName)) {
                return $storeFileName;
            }
        }

        return null;
    }
}