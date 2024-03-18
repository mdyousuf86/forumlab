<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Topic;

class ManageTopicController extends Controller {
    public function list() {
        $pageTitle = 'All Topics';
        $topics    = $this->filterTopic();
        return view('admin.topic.list', compact('pageTitle', 'topics'));
    }
    public function pending() {
        $pageTitle = 'Pending Topics';
        $topics    = $this->filterTopic('pending');
        return view('admin.topic.list', compact('pageTitle', 'topics'));
    }
    public function approved() {
        $pageTitle = 'Approved Topics';
        $topics    = $this->filterTopic('approved');
        return view('admin.topic.list', compact('pageTitle', 'topics'));
    }

    public function trashed() {
        $pageTitle = 'Approved Topics';
        $topics    = $this->filterTopic('trashed');
        return view('admin.topic.list', compact('pageTitle', 'topics'));
    }
    public function rejected() {
        $pageTitle = 'Rejected Topics';
        $topics    = $this->filterTopic('rejected');
        return view('admin.topic.list', compact('pageTitle', 'topics'));
    }

    protected function filterTopic($scope = null) {
        $topics = Topic::query();
        if ($scope) {
            $topics = $topics->$scope();
        }
        return $topics->with('subcategory:id,name', 'user')->searchable(['title', 'subcategory:name'])->latest()->paginate(getPaginate());
    }

    public function detail($id) {

        $topic = Topic::with(['user:id,username', 'subcategory' => function ($query) {
            $query->with(['category' => function ($q) {
                $q->with('forum:id,name');
            }]);
        }])->findOrFail($id);
        $pageTitle = 'Topic - ' . $topic->title;
        return view('admin.topic.detail', compact('pageTitle', 'topic'));
    }

    public function approve($id) {

        $topic = Topic::pending()->with(['user' => function ($query) {
            $query->active();
        }])->findOrFail($id);

        $topic->status = Status::TOPIC_APPROVED;
        $topic->save();

        $user = $topic->user;
        notify($user, 'TOPIC_APPROVED', [
            'username' => $user->username,
            'title'    => $topic->title,
        ]);
        $notify[] = ['success', 'Topic approved successfully'];
        return back()->withNotify($notify);
    }

    public function reject($id) {

        $topic = Topic::pending()->with(['user' => function ($query) {
            $query->active();
        }])->findOrFail($id);

        $topic->status = Status::TOPIC_REJECTED;
        $topic->save();

        $user = $topic->user;
        notify($user, 'TOPIC_REJECTED', [
            'username' => $user->username,
            'title'    => $topic->title,
        ]);

        $notify[] = ['success', 'Topic rejected successfully'];
        return back()->withNotify($notify);
    }

    public function comments($id) {
        $topic     = Topic::findOrFail($id);
        $pageTitle = "Comment List - " . $topic->title;
        $comments  = Comment::where('topic_id', $topic->id)->with('user')->searchable(['comment', 'user:username'])->latest()->paginate(getPaginate());
        return view('admin.topic.comments', compact('comments', 'pageTitle'));
    }

    public function commentDelete($id, $topicId) {
        Comment::where('id', $id)->delete();
        $topic = Topic::findOrFail($topicId);
        $topic->decrement('comment');
        $topic->save();
        $notify[] = ['success', 'Comment deleted successfully'];
        return back()->withNotify($notify);
    }
}
