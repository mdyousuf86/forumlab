<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle                = 'Dashboard';
        $userId                   = authId();
        $widget['total_topic']    = Topic::where('user_id', $userId)->count();
        $widget['pending_topic']  = Topic::where('user_id', $userId)->pending()->count();
        $widget['approved_topic'] = Topic::where('user_id', $userId)->approved()->count();
        $widget['rejected_topic'] = Topic::where('user_id', $userId)->rejected()->count();
        $topics                   = Topic::available()->where('user_id', $userId)->latest()->with('subcategory:id,name')->limit(8)->get();
        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'topics', 'widget'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits  = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'deposits'));
    }


    public function attachmentDownload($fileHash)
    {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general   = gs();
        $title     = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype  = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->address   = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'city'    => $request->city,
        ];
        $user->profile_complete = 1;
        $user->save();

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }
}
