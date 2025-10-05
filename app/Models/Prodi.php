<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Prodi extends Model
{
    protected $table = 'prodis';
    protected $primaryKey = 'id_prodi';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id_prodi',
        'kode_program_studi',
        'nama_program_studi',
        'status',
        'id_jenjang_pendidikan',
        'nama_jenjang_pendidikan',
        'jenjang_nama_prodi'
    ];

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($q) use ($term) {
            $q->where('kode_program_studi', 'like', $term)
                ->orWhere('jenjang_nama_prodi', 'like', $term);
        });
    }
}
