<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    const MANAGER = 'manager';
    const AGENT = 'agent';

    protected $fillable = [
        'name', 'source', 'owner', 'created_by'
    ];

}