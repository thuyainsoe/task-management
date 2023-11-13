<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'priority',
        'start_date',
        'due_date',
        'completion_date', 
    ];

    public function updateWhenAssigned($args)
    {
        $data = [];
        if(isset($args['start_date'])) {
            $data['start_date'] = $args['start_date'];
        }

        if(isset($args['due_date'])) {
            $data['due_date'] = $args['due_date'];
        }

        $this->update($data);
    }
}