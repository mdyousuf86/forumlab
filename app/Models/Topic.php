<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model {
    use Searchable;

    protected $casts = [
        'tags' => 'object',
    ];
    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function votes() {
        return $this->hasMany(Vote::class, 'topic_id');
    }
    public function latestComment() {
        return $this->hasOne(Comment::class)->latestOfMany();
    }
    public function statusBadge(): Attribute {
        return new Attribute(
            get:fn() => $this->badgeData(),
        );
    }
    public function badgeData() {
        $html = '';
        if ($this->status == Status::TOPIC_PENDING) {
            $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
        } else if ($this->status == Status::TOPIC_APPROVED) {
            $html = '<span class="badge badge--success">' . trans('Approved') . '</span>';
        } else if ($this->status == Status::TOPIC_REJECTED) {
            $html = '<span class="badge badge--danger">' . trans('Rejected') . '</span>';
        } else {
            $html = '<span class="badge badge--dark">' . trans('Deleted') . '</span>';
        }
        return $html;
    }
    public function scopePending($query) {
        return $query->where('status', Status::TOPIC_PENDING);
    }
    public function scopeApproved($query) {
        return $query->where('status', Status::TOPIC_APPROVED);
    }
    public function scopeTrashed($query) {
        return $query->where('status', Status::TOPIC_TRASHED);
    }
    public function scopeRejected($query) {
        return $query->where('status', Status::TOPIC_REJECTED);
    }
    public function scopeAvailable($query) {
        return $query->approved()->whereHas('subcategory', function ($subcategory) {
            $subcategory->active()->whereHas('category', function ($category) {
                $category->active()->whereHas('forum', function ($forum) {
                    $forum->active();
                });
            });
        });
    }
}
