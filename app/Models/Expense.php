<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['description', 'amount', 'spent_at'];

    protected function casts(): array
    {
        return ['spent_at' => 'date'];
    }
}
