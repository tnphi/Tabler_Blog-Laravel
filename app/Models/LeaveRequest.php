<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $table = 'leave_requests';
    protected $fillable = ['user_id', 'leave_type', 'content', 'is_confirm'];

    public function leaveDates()
    {
        return $this->hasMany(LeaveDate::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
