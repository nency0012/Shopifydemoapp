<?php

namespace App\Console\Commands;

use App\Jobs\CustomersCreateJob;
use App\Jobs\OrdersCreateJob;
use App\Models\User;
use Illuminate\Console\Command;

class unique extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ordercreate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       $shop = User::Where('name','demo-nency-patel.myshopify.com')->first();
       $request = $shop->api()->rest('GET', '/admin/api/2021-04/Orders/3661365608634.json');
      // $request = $shop->api()->rest('POST', '/admin/api/2021-04/Orders.json');
        $data  = $request['body']['order'];
        OrdersCreateJob::dispatch('demo-nency-patel.myshopify.com',$data);


        $request = $shop->api()->rest('GET','/admin/api/2021-04/customers/5042402787514.json');
        $data = $request['body']['customer'];
        CustomersCreateJob::dispatch('demo-nency-patel.myshopify.com',$data);
        return 0;

    }

}
