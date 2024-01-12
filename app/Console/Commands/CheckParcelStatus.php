<?php

namespace App\Console\Commands;

use App\Model\Parcel;
use App\Services\parcels\RedxService;
use Illuminate\Console\Command;

class CheckParcelStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:parcel-status';

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
        try{
            $parcels = Parcel::where('status',0)->where('tracking_id', '!=','')->where('courier_name', 'REDX')->get();
            $redxService = new RedxService();
            if(count($parcels)){
                foreach ($parcels as $parcel){
                    $order = $parcel->order;
                    $parcelData = $redxService->infoParcel($parcel->tracking_id);
                    $parcelStatus = isset($parcelData['parcel_info']) ? $parcelData['parcel_info'] : [];
                    $parcel->parcel_status_remarks = json_encode($parcelStatus);
                    $statusData = isset($parcelStatus['status']) ? $parcelStatus['status'] : '';
                    if(isset($statusData) && $statusData == 'pickup-delivery') {
                        $status = '1';
                    } else {
                        $status = '0';
                    }
                    $parcel->status = $status;
                    $order->delivery_status = $status;
                    $order->save();
                    $parcel->save();
                }
            }
        }catch (\Exception $exception){
            \Log::error('parcel error: '.$exception->getMessage());
        }
        return 0;
    }
}
