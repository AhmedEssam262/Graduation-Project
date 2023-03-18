<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient_record extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'illnesses_history',
        'test_results',
        'current_issue',
        'allergies',
        'immunizations',
        'surgeries'
    ];
}
