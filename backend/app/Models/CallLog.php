<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CallLog extends Model
{
    use HasUuids, HasFactory;

    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

     public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
