<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Forum;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Subcategory;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SiteController extends Controller
{
    public function index()
    {

        $pageTitle = 'Home';
        if (request()->routeIs('all.topic')) {
            $pageTitle = 'All Topic';
        }
        $forums = Forum::active()->searchable(['name', 'categories:name', 'categories.subcategories:name', 'categories.topics:title'])->withWhereHas('categories', function ($category) {
            $category->active()->with('subcategories', 'topics.latestComment')->withWhereHas('topics', function ($topic) {
                $topic->where('topics.status', Status::TOPIC_APPROVED)->orderBy('topics.id', 'desc')->with(['user' => function ($q) {
                    $q->select('id', 'image', 'username');
                }])->whereHas('subcategory', function ($q) {
                    $q->active();
                });
            })->latest();
        })->get();
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections', 'forums'));
    }

    public function forums($slug, $id)
    {
        $forums = Forum::active()->where('id', $id)->withWhereHas('categories', function ($category) {
            $category->active()->with('subcategories', 'topics.latestComment')->withWhereHas('topics', function ($topic) {
                $topic->where('topics.status', Status::TOPIC_APPROVED)->whereHas('subcategory', function ($q) {
                    $q->active();
                });
            })->latest()->withCount('topics');
        })->first();

        if (!$forums) {
            $notify[] = ['warning', "Sorry !, No topic found under this forum"];
            return back()->withNotify($notify);
        }

        $pageTitle = $slug . ' - All Categories';
        return view($this->activeTemplate . 'forums', compact('pageTitle', 'forums'));
    }

    public function categoryTopics($slug, $id)
    {
        $category = Category::available()->with('subcategories')->findOrFail($id);
        $topics   = $category->topics()->with('user:id,username,image')->where('topics.status', Status::TOPIC_APPROVED)->withWhereHas('subcategory', function ($q) {
            $q->active();
        })->paginate(getPaginate());
        $pageTitle = $category->name . ' - All Forum';
        return view($this->activeTemplate . 'topics', compact('pageTitle', 'topics', 'category'));
    }
    public function subCategoryTopics($slug, $id)
    {
        $subcategory = Subcategory::available()->findOrFail($id);
        $pageTitle   = $subcategory->name . ' - All Forum';
        $topics      = $subcategory->topic()->with('user:id,username,image', 'subcategory')->where('status', Status::TOPIC_APPROVED)->paginate(getPaginate());
        return view($this->activeTemplate . 'topics', compact('pageTitle', 'topics', 'subcategory'));
    }

    public function detail($slug, $id)
    {
        $topic = Topic::available()->withCount('comments')->findOrFail($id);

        if (auth()->id() != $topic->user_id) {
            $topic->increment('view');
            $topic->save();
        }
        $comments  = $topic->comments()->with('user')->latest()->take(5)->get();
        $pageTitle = $topic->title;

        $seoContents['keywords']           = $topic->meta_keywords ?? [];
        $seoContents['social_title']       = $topic->title;
        $seoContents['description']        = strLimit(strip_tags($topic->description), 150);
        $seoContents['social_description'] = strLimit(strip_tags($topic->description), 150);
        if (@$topic->imag) {
            $seoContents['image']      = getImage(getFilePath('topic') . '/' . @$topic->image);
            $seoContents['image_size'] = getFileSize('topic');
        } else {
            $seo          = Frontend::where('data_keys', 'seo.data')->first();
            $seoContents['image']      = getImage(getFilePath('seo') . '/' . @$seo->data_values->image);
            $seoContents['image_size'] = getFileSize('seo');
        }
        return view($this->activeTemplate . 'topic_detail', compact('pageTitle', 'topic', 'comments', 'seoContents'));
    }

    public function fetchComments(Request $request, $id)
    {
        $topic = Topic::available()->where('id', $id)->first();
        if (!$topic) {
            return response()->json([
                'status'       => 'error',
                'notification' => 'Topic not found',
            ]);
        }
        $comments = Comment::where('topic_id', $topic->id)->skip($request->skipComment)->take(5)->with('user')->get();
        if ($comments->count()) {
            return view($this->activeTemplate . 'partials.comments', compact('comments'));
        } else {
            return response()->json([
                'status'       => 'error',
                'notification' => 'No more comments yet',
            ]);
        }
    }

    public function profile($username)
    {
        $user      = User::active()->where('username', $username)->firstOrFail();
        $pageTitle = 'About - ' . $user->username;
        $userId    = $user->id;
        $topics    = Topic::where('user_id', $user->id)->available();

        if (request()->routeIs('profile.topics')) {
            $pageTitle = 'All Topic - ' . $user->username;
        }

        if (request()->routeIs('profile.answered')) {
            $pageTitle = 'Answered By - ' . $user->username;
            $topics->withWhereHas('comments', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            });
        }

        if (request()->routeIs('profile.up.vote')) {
            $pageTitle = 'Up vote By - ' . $user->username;
            $topics->withWhereHas('votes', function ($query) use ($userId) {
                $query->where('vote', Status::UP_VOTE)->where('user_id', $userId);
            });
        }

        if (request()->routeIs('profile.down.vote')) {
            $pageTitle = 'Down vote By - ' . $user->username;

            $topics->withWhereHas('votes', function ($query) use ($userId) {
                $query->where('vote', Status::DOWN_VOTE)->where('user_id', $userId);
            });
        }

        $topics = $topics->with('subcategory:id,name')->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'profile', compact('user', 'pageTitle', 'topics'));
    }

    public function adRedirect($hash)
    {
        $ad = Advertisement::findOrFail(decrypt($hash));
        $ad->increment('click');
        $ad->save();
        return redirect(@$ad->content->link);
    }

    public function adCountAjax(Request $request)
    {
        $ad = Advertisement::where('id', decrypt($request->id))->first();
        if ($ad) {
            $ad->click += 1;
            $ad->save();
        }
    }

    public function pages($slug)
    {
        $page      = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections  = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }

    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required',
            'email'   => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket           = new SupportTicket();
        $ticket->user_id  = auth()->id() ?? 0;
        $ticket->name     = $request->name;
        $ticket->email    = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;

        $ticket->ticket     = $random;
        $ticket->subject    = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status     = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title     = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message                    = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message           = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy    = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) {
            $lang = 'en';
        }

        session()->put('lang', $lang);
        return back();
    }

    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie    = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;
        $fontFile  = realpath('assets/font/RobotoMono-Regular.ttf');
        $fontSize  = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox    = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        $general   = gs();
        if ($general->maintenance_mode == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view($this->activeTemplate . 'maintenance', compact('pageTitle', 'maintenance'));
    }
}
