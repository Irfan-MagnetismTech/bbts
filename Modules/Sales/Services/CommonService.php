<?php

namespace Modules\Sales\Services;

class CommonService
{
    public static function fileUpload($file, $path)
    {
        $file_name = time() . '.' . $file->getClientOriginalExtension();
        $file->move($path, $file_name);
        return $file_name;
    }

    public static function updateFileUpload($file, $path, $old_file)
    {
        if ($file) {
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $file_name);
            if (file_exists($old_file)) {
                unlink($old_file);
            }
            return $file_name;
        }
        return $old_file;
    }

    public static function deleteFile($file)
    {
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
