<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_folder_id',
        'department_id',
        'created_by',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parentFolder()
    {
        return $this->belongsTo(Folder::class, 'parent_folder_id');
    }

    public function childFolders()
    {
        return $this->hasMany(Folder::class, 'parent_folder_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
