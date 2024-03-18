<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use Searchable;
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function topic() {
        return $this->belongsTo(Topic::class);
    }
}
