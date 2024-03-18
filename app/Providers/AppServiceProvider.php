<?php

namespace App\Providers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Forum;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Subcategory;
use App\Models\SupportTicket;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $general                         = gs();
        $activeTemplate                  = activeTemplate();
        $viewShare['general']            = $general;
        $viewShare['activeTemplate']     = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language']           = Language::all();
        $viewShare['emptyMessage']       = 'Data not found';
        view()->share($viewShare);

        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'           => User::banned()->count(),
                'emailUnverifiedUsersCount'  => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount' => User::mobileUnverified()->count(),
                'pendingTicketCount'         => SupportTicket::whereIN('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count(),
                'pendingTopic'               => Topic::pending()->count(),
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications'     => AdminNotification::where('is_read', Status::NO)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('is_read', Status::NO)->count(),
            ]);
        });

        view()->composer($activeTemplate . 'partials.left_side', function ($view) {
            $view->with([
                'forums'      => Forum::active()->latest()->get(),
                'categories'  => Category::available()
                    ->latest()
                    ->get(),
                'discussions' => Topic::available()->orderBy('comment', 'desc')->limit(10)->get(),
            ]);
        });

        view()->composer($activeTemplate . 'partials.right_side', function ($view) {
            $view->with([
                'forum'           => Forum::active()->count(),
                'category'        => Category::available()->count(),
                'subCategory'     => Subcategory::available()->count(),
                'topic'           => Topic::available()->count(),
                'unTalks'         => Topic::available()
                    ->where('comment', 0)
                    ->with('user')
                    ->latest()
                    ->limit(10)
                    ->get(),
                'topContributors' => Comment::selectRaw('user_id, count(*) as total')
                    ->with('user')
                    ->groupBy('user_id')
                    ->orderBy('total', 'desc')
                    ->limit(10)
                    ->get(),
                'hots'            => Comment::selectRaw('topic_id, count(*) as total')
                    ->whereDate('created_at', '>', now()->subDays(3))
                    ->with('topic.user')
                    ->groupBy('topic_id')
                    ->orderBy('total', 'desc')
                    ->limit(10)
                    ->whereHas('topic', function ($topic) {
                        $topic->available();
                    })->get(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if ($general->force_ssl) {
            \URL::forceScheme('https');
        }

        Paginator::useBootstrapFour();
    }
}
