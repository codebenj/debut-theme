<?php

namespace App\Console\Commands;

use App\Blog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateBlogStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blogstatus:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Blog status update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger("Blog status update cron");
        $draftBlogs = Blog::where('status', 0)->get();

        foreach ($draftBlogs as $key => $draftBlog) {
            $auto_publish_at = Carbon::parse($draftBlog->auto_publish_at);
            if ($auto_publish_at->isToday() || $auto_publish_at->isPast()) {
                $draftBlog->auto_publish_at = null;
                $draftBlog->status = 1;
            } else {
                $draftBlog->status = 0;
            }
                $draftBlog->save();
            }
        }
    }
