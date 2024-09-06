<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveDate extends Model
{
    protected $fillable = ['leave_request_id', 'leave_date'];

    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class);
    }
    use HasFactory;
}
