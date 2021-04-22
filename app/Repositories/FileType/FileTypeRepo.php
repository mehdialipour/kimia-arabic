<?php

namespace App\Repositories\FileType;

use App\Models\FileType;

class FileTypeRepo
{
    public static function all()
    {
        return FileType::all();
    }
}
