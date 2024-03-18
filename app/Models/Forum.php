<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model {
    use Searchable, GlobalStatus;
    public function categories() {
        return $this->hasMany(Category::class);
    }
    public function statusBadge(): Attribute {
        return new Attribute(
            get:fn() => $this->badgeData(),
        );
    }
    public function badgeData() {
        $html = '';
        if ($this->status == Status::FORUM_ACTIVE) {
            $html = '<span class="badge badge--success">' . trans('Active') . '</span>';
        } else {
            $html = '<span class="badge badge--warning">' . trans('Inactive') . '</span>';
        }
        return $html;
    }
    public function scopeActive($query) {
        return $query->where('status', Status::FORUM_ACTIVE);
    }
}
