<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = ['title', 'is_completed', 'due_date', 'user_id', 'group_id'];

    protected $dates = ['created_at', 'updated_at'];
}
