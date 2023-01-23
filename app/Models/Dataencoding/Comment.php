<?php

namespace App\Models\Dataencoding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Comment extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['user_id', 'commentable_id', 'commentable_type'];

    public function commentable()
    {
        return $this->morphTo();
    }
}
