<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearOrphanedAttachments extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:coa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up motherfucker';

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
     * @return mixed
     */
    public function handle()
    {
	    $orphaned = \App\Attachment::whereNull('article_id')
		    ->where('created_at', '<', \Carbon\Carbon::now()
			    ->subWeek())
		    ->get();

	    foreach ($orphaned as $attachment) {
	    	$path   = attachments_path($attachment->filename);
	    	\File::delete($path);
	    	$attachment->delete();
	    	$this->line('Delete'.$path);
        }

        $this->info('All Clean! All done! Dump Ass');

	    return ;
    }
}
