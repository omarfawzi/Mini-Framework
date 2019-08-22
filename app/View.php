<?php

namespace App;

use Exception;

class View
{
    /**
     * @param string $templatePath
     * @return bool
     */
    private static function isTemplateExists(string $templatePath)
    {
        $file_parts = pathinfo($templatePath);

        return file_exists($templatePath) && $file_parts['extension'] == 'php';
    }

    /**
     * @param string $templatePath
     * @param array  $data
     * @return string
     * @throws Exception
     */
    public static function render(string $templatePath, array $data = []): string
    {
        $templatePath = config('views','path') .'/'. $templatePath;
        if (!self::isTemplateExists($templatePath)) {
            throw new Exception("Template at $templatePath don't exists");
        }
        ob_start();
        extract($data);
        require($templatePath);

        return ob_get_clean();
    }
}