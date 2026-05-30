<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoLog extends Model {
    protected $table = 'photo_logs';
    protected $fillable = ['lahan_id', 'current_hst', 'fase_tanaman', 'file_path', 'keterangan'];
}
