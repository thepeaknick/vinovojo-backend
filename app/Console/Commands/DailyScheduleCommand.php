<?php

    namespace App\Console\Commands;

    use \Carbon\Carbon;
    use App\Wine;
    use App\Winery;
    use App\Highlight;
    use App\Happening;
    use App\Advertising;
    use Illuminate\Console\Scheduling\Schedule;
    use Laravel\Lumen\Console\Kernel as ConsoleKernel;
    use Illuminate\Console\Command;

    class DailyScheduleCommand extends Command
    {
        protected $signature = 'check:daily';
        protected $description = 'Running unit daily report check';

        public function __construct()
        {
            parent::__construct();
        }

        public function handle($input, $output=NULL)
        {
            \Log::info([ 'message'=>'cron report' ]);
            static::removeDuplicates();
            $this->repairWineriesWinesStatus();
            $this->repairEventsStatus();
            // $this->repairAdsStatus();
        }

        /**
         * Metoda koja za marketing vina i vinarija,
         * prolazi kroz sva istaknuta i preporučena 
         * vina i vinarije, provjerava datum i provjerava status
         * **ako je datum validan (ako je sudeći po dataumu aktivna)
         *      1) ako je status 0 -> podignuće status na 1
         *      2) ako je status 1 -> ostaviće status na 1
         * **ako datum nije validan (sudeći po datumu ne bi trebalo da se prikazuje)
         *      1) spušta status na 0 bez obzira na prethodno stanje statusa
         *
         * @return void
         */
        public function repairWineriesWinesStatus()
        {
            (new \App\Http\Controllers\HighlightController())->insertNeccessaryData();
            $data= Highlight::query();
            foreach($data->where('type','1')->get() as $highlight) {
                $e_type= 'highlighted';
                if($this->isExpired($highlight->start_date,$highlight->end_date, $highlight) || $highlight->status==0) {
                    if($highlight->object_type==3)
                        $this->repairWinery($highlight->object_id, $e_type, 0);
                    if($highlight->object_type==2)
                        $this->repairWine($highlight->object_id, $e_type, 0);
                }else {
                    // if not expired
                    if($highlight->object_type==3)
                        $this->repairWinery($highlight->object_id, $e_type,1);
                    else if($highlight->object_type==2)
                        $this->repairWine($highlight->object_id, $e_type, 1);
                }
            }

            // for recommended
            foreach($data->where('type','2')->get() as $recommended) {
                $e_type= 'recommended';
                if($this->isExpired($recommended->start_date, $recommended->end_date, $recommended) || $recommended->status==0) {
                    if($recommended->object_type==3)
                        $this->repairWinery($recommended->object_id, $e_type, 0);
                    if($recommended->object_type==2)
                        $this->repairWine($recommended->object_id, $e_type, 0);
                }else {
                    // if not expired
                    if($recommended->object_type==3)
                        $this->repairWinery($recommended->object_id, $e_type, 1);
                    if($recommended->object_type==2)
                        $this->repairWine($recommended->object_id, $e_type, 1);
                }
            }
        }

        public function isExpired($from,$to, $object=false) {
            $now=Carbon::now();
            if($object) {
                // \Log::info('Object: ');
                // \Log::info('date from: ');
                // \Log::info(print_r($from,true));
                // \Log::info('date to: ');
                // \Log::info(print_r($to,true));
            }
            $startdate=new Carbon(date($from));
            $enddate=new Carbon( date($to) );
            $now=Carbon::now();
            // if time is not expired
            if( $now->lt( $enddate ) && $now->gt($startdate)){
                return 0;
            }
            return 1;
        }

        public function repairWinery($id, $type, $status)
        {
            $winery= Winery::where('id',$id)->first();
            if($winery!=null) {
                if($type=='recommended')
                    $winery->recommended= $status;
                else $winery->highlighted= $status;
                \Log::info("Winery: ");
                \Log::info('tip: '.$type);
                \Log::info('status: '.$status);
                \Log::info(print_r($winery,true));
            }
            // \DB::table('wineries')->where('id', $id)->update([$type => $status]);
        }

        public function repairWine($id, $type, $status)
        {
            $wine= Wine::where('id',$id)->first();
            if($wine!=null) {
                if($type=='recommended')
                    $wine->recommended= $status;
                else $wine->highlighted= $status;
                \Log::info("Wine: ");
                \Log::info('tip: '.$type);
                \Log::info('status: '.$status);
                \Log::info(print_r($wine,true));
            }
            // \DB::table('wines')->where('id', $id)->update([$type => $status]);
        }

        /**
         * Metoda koja iskljucuje status aktivno za desavanje
         * u slucaju samo kada je istekao datum
         * znaci trenutni datum > end date
         *
         * @return void
         */
        public function repairEventsStatus()
        {
            foreach(Happening::all() as $event) {
                $now= Carbon::now();
                $end= new Carbon (date($event->end));
                // if is event finished
                if($now->gt($end)) {
                    // \Log::info('Veci je datum');
                    // \Log::info(print_r($event,true));
                    $event->active = 0;
                    $event->save();
                }
            }
            return true;
        }

        public function repairAdsStatus()
        {
            foreach(Advertising::all() as $ads) {
                $now= Carbon::now();
                $start_date= new Carbon(date($ads->start_date));
                $end_date= new Carbon(date($ads->end_date));
                if($now->gt($end_date)) {
                    $ads->status=0;
                    $ads->save();
                }
            }
        }

        public static function removeDuplicates()
        {
            foreach(\App\Highlight::orderBy('id','asc')->get() as $highlight) {
                $duplicates= \App\Highlight::where('object_id',$highlight->object_id)
                                        ->where('object_type',$highlight->object_type)
                                        ->where('type',$highlight->type)
                                        ->where('id','>',$highlight->id)
                                        ->get();
                foreach($duplicates as $duplicate) {
                    if($duplicate->id!==$highlight->id)
                        $duplicate->delete();
                }
            }
            return true;
        }


        
    }

?>