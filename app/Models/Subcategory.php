<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model {
    use Searchable, GlobalStatus;

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function latestComment() {
        return $this->hasOneThrough(Comment::class, Topic::class);
    }
    public function topic() {
        return $this->hasMany(Topic::class);
    }
    public function statusBadge(): Attribute {
        return new Attribute(
            get:fn() => $this->badgeData(),
        );
    }
    public function badgeData() {
        $html = '';
        if ($this->status == Status::SUBCATEGORY_ACTIVE) {
            $html = '<span class="badge badge--success">' . trans('Active') . '</span>';
        } else {
            $html = '<span class="badge badge--warning">' . trans('Inactive') . '</span>';
        }
        return $html;
    }
    public function scopeActive($query) {
        return $query->where('status', Status::SUBCATEGORY_ACTIVE);
    }
    public function scopeAvailable($query) {
        return $query->active()->whereHas('category', function ($category) {
            $category->active()->whereHas('forum', function ($forum) {
                $forum->active();
            });
        });
    }
}
