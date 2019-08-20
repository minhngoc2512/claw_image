<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Storage;

class ClawImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'claw:image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Claw image';

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
        $domain = 'https://alonhadat.com.vn';
        $page = 2;
        for(;;){
            $html = file_get_html($domain."/nha-dat/can-ban/trang--$page.html");
            foreach ($html->find('div[class=ct_title] a')  as $href ){
                $detail = file_get_html("$domain/".$href->href);
                $this->comment("$domain/".$href->href);
                $detail = $detail->find('div[class=detail] img');
                foreach ($detail as $image){
                    $image_dow = file_get_contents($domain.'/'.$image->src);
                    $file_name = explode('/',$image->src);
                    $this->info('file:'.end($file_name));
                    Storage::put('images/alonhadat/'.end($file_name),$image_dow);
                }
            }
            $page++;
           if($page==10) break;
        }
        //
    }
}
