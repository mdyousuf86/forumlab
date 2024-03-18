<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Searchable, GlobalStatus;

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id')->active();
    }
    public function topics()
    {
        return $this->hasManyThrough(Topic::class, Subcategory::class);
    }
    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn () => $this->badgeData(),
        );
    }
    public function badgeData()
    {
        $html = '';
        if ($this->status == Status::CATEGORY_ACTIVE) {
            $html = '<span class="badge badge--success">' . trans('Active') . '</span>';
        } else {
            $html = '<span class="badge badge--warning">' . trans('Inactive') . '</span>';
        }
        return $html;
    }
    public function scopeActive($query)
    {
        return $query->where('status', Status::CATEGORY_ACTIVE);
    }
    public function scopeAvailable($query)
    {
        return $query->where('status', Status::CATEGORY_ACTIVE)->whereHas('forum', function ($forum) {
            $forum->active();
        });
    }
}
