<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Comment;
use App\Models\Subcategory;
use App\Models\Topic;
use App\Models\Vote;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{

    public function list()
    {
        $pageTitle = 'All Topics';
        $topics    = $this->filterTopic();
        return view($this->activeTemplate . 'user.topic.list', compact('pageTitle', 'topics'));
    }
    public function pending()
    {
        $pageTitle = 'Pending Topics';
        $topics    = $this->filterTopic('pending');
        return view($this->activeTemplate . 'user.topic.list', compact('pageTitle', 'topics'));
    }
    public function approved()
    {
        $pageTitle = 'Approved Topics';
        $topics    = $this->filterTopic('approved');
        return view($this->activeTemplate . 'user.topic.list', compact('pageTitle', 'topics'));
    }
    public function rejected()
    {
        $pageTitle = 'Rejected Topics';
        $topics    = $this->filterTopic('rejected');
        return view($this->activeTemplate . 'user.topic.list', compact('pageTitle', 'topics'));
    }

    protected function filterTopic($scope = null)
    {

        $topics = Topic::where('user_id', authId());
        if ($scope) {
            $topics = $topics->$scope();
        }
        return $topics->where('status', '!=', Status::TOPIC_TRASHED)->with('subcategory:id,name')->searchable(['title', 'subcategory:name'])->filter(['status'])->latest()->paginate(getPaginate());
    }

    public function detail($id)
    {
        $topic = Topic::where('user_id', authid())->with(['subcategory' => function ($query) {
            $query->select('id', 'name', 'category_id')->with(['category' => function ($q) {
                $q->select('id', 'name', 'forum_id')->with('forum:id,name');
            }]);
        }])->findOrFail($id);
        $pageTitle = 'Topic - ' . $topic->title;
        return view($this->activeTemplate . 'user.topic.detail', compact('pageTitle', 'topic'));
    }

    public function form($id = 0)
    {
        $pageTitle     = 'Topic Form';
        $subcategories = Subcategory::available()->with('category')->orderBy('name')->get(['id', 'name', 'category_id']);
        $topic         = null;
        if ($id) {
            $pageTitle = 'Update Topic';
            $topic     = Topic::where('status', '!=', Status::TOPIC_TRASHED)->where('user_id', authId())->findOrFail($id);
        }
        return view($this->activeTemplate . 'user.topic.form', compact('pageTitle', 'subcategories', 'topic'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'subcategory_id' => 'required|integer',
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'tags'           => 'required|array|min:1',
            'tags.*'         => 'required|string',
            'video'          => 'nullable|string|url',
            'image'          => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $general     = gs();
        $user        = authUser();
        $subCategory = Subcategory::where('id',$request->subcategory_id)->firstOrFail();

        if ($id) {
            $topic        = Topic::where('status', '!=', Status::TOPIC_TRASHED)->where('user_id', $user->id)->findOrFail($id);
            $notification = 'Topic updated successfully';
        } else {
            $topic          = new Topic();
            $notification   = 'Topic created successfully';
            $topic->user_id = $user->id;
        }

        if ($request->hasFile('image')) {
            try {
                $topic->image = fileUploader($request->image, getFilePath('topic'), getFileSize('topic'), @$topic->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $topic->tags           = $request->tags;
        $topic->subcategory_id = $subCategory->id;
        $topic->title          = $request->title;
        $topic->description    = $request->description;
        $topic->status         = $general->auto_approval ? Status::TOPIC_APPROVED : Status::TOPIC_PENDING;
        $topic->video          = $request->video;
        $topic->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New topic created by ' . $user->username;
        $adminNotification->click_url = urlPath('admin.topic.detail', $topic->id);
        $adminNotification->save();

        notify($user, $general->auto_approval ? 'TOPIC_APPROVED' : 'TOPIC_REQUEST', [
            'username' => $user->username,
            'title'    => $topic->title,
        ]);

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $topic         = Topic::where('status', '!=', Status::TOPIC_TRASHED)->where('user_id', authId())->findOrFail($id);
        $topic->status = Status::TOPIC_TRASHED;
        $topic->save();

        $notify[] = ['success', 'Topic deleted successfully'];
        return back()->withNotify($notify);
    }

    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $topic = Topic::available()->findOrFail($id);

        $comment           = new Comment();
        $comment->user_id  = authId();
        $comment->topic_id = $topic->id;
        $comment->comment  = $request->comment;
        $comment->save();

        $topic->increment('comment');
        $topic->save();

        $notify[] = ['success', 'Comment created successfully'];
        return back()->withNotify($notify);
    }

    public function vote(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'vote_type' => 'required|integer|in:1,2',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()]);
        }

        $topic = Topic::available()->where('id', $id)->first();
        if (!$topic) {
            return response()->json(['status' => 'error', 'message' => 'Topic not found']);
        }
        $preVote = Vote::where('user_id', authId())->where('topic_id', $topic->id)->first();

        $message = ($request->vote_type == Status::UP_VOTE) ? 'Up' : 'Down';
        if ($preVote) {

            if ($preVote->vote == $request->vote_type) {
                $notification = 'Already ' . $message . ' Voted';
                return response()->json(['status' => 'error', 'message' => $notification]);
            } else {
                if ($request->vote_type == Status::UP_VOTE) {
                    $preVote->vote = Status::UP_VOTE;
                    $topic->increment('up_vote');
                    $topic->decrement('down_vote');
                } else {
                    $preVote->vote = Status::DOWN_VOTE;
                    $topic->decrement('up_vote');
                    $topic->increment('down_vote');
                }

                $preVote->save();
                $topic->save();

                return response()->json([
                    'status'  => 'success',
                    'message' => $message . ' vote added successfully',
                    'down'    => $topic->down_vote,
                    'up'      => $topic->up_vote,
                ]);
            }
        }

        $vote           = new Vote();
        $vote->user_id  = authId();
        $vote->topic_id = $topic->id;
        $vote->vote     = $request->vote_type;
        $vote->save();

        if ($request->vote_type == Status::UP_VOTE) {
            $topic->increment('up_vote');
        } else {
            $topic->increment('down_vote');
        }
        $topic->save();

        return response()->json([
            'status'  => 'success',
            'message' => $message . ' added successfully',
            'down'    => $topic->down_vote,
            'up'      => $topic->up_vote,
        ]);
    }
}
