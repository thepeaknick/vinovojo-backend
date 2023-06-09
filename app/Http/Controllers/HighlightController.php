<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;

    use App\Wine;
    use App\Winery;
    use App\Highlight;
    use Carbon\Carbon;

    define('WINERY_TYPE',3);
    define('WINE_TYPE',2);

    define('HIGH',1);
    define('REC',2);
    class HighlightController extends BaseController
    {
        public function change(Request $r)
        {
            return Highlight::storeOrChange($r);
        }
        public function all()
        {
            return Highlight::getAll();
        }
        public function insertNeccessaryData()
        {
            foreach(Wine::all() as $wine)
            {
                //for Recommended
                $data=[
                    'object_id'=>$wine->id,
                    'object_type'=>WINE_TYPE,
                    'type'=>REC,
                    'status'=>$wine->recommended,
                    'start_date'=> Carbon::create(),
                    'end_date'=> Carbon::create()
                ];
                $self= Highlight::where('object_id',$data['object_id'])->where('object_type',$data['object_type'])->where('type',$data['type'])->first();
//                 dd($self);
                $request=new \Illuminate\Http\Request($data);
                if(!$self) {


                    $recommended=new Highlight();
                    $recommended->storeOrChange($request);
                }


                // for Highlighted
                $request['type']=HIGH;
                $request['status']=$wine->highlighted;
                $self= Highlight::where('object_id',$request['object_id'])->where('object_type',$request['object_type'])->where('type',$request['type'])->first();
                if(!$self) {
                    $highlighted=new Highlight();
                    //                    dd($request);
                    $highlighted->storeOrChange($request);
                }



            }
            $data=[];
            foreach(\App\Winery::all() as $winery)
            {
                $data=[
                    'object_id'=>$winery->id,
                    'object_type'=>WINERY_TYPE,
                    'type'=>REC,
                    'status'=>$winery->recommended,
                    'start_date'=> Carbon::create(),
                    'end_date'=> Carbon::create()
                ];

                $request=new \Illuminate\Http\Request($data);
                $self= Highlight::where('object_id',$request['object_id'])->where('object_type',$request['object_type'])->where('type',$request['type'])->first();
                if(!$self) {
                    $recommended=new Highlight;
                     $recommended->storeOrChange($request);
                }

                $request['type']=HIGH;
                $request['status']=$winery->highlighted;
                $self= Highlight::where('object_id',$request['object_id'])->where('object_type',$request['object_type'])->where('type',$request['type'])->first();
                \Log::info("Self: ",(array)($self));
                if(!$self) {
                    $highlighted=new Highlight;
                    $highlighted->storeOrChange($request);
                }

            }
        }
        public function show(Request $r)
        {
            $this->insertNeccessaryData();
            if($r->has(['object_id','object_type','type']))
            {
                $data= Highlight::where('object_id',$r['object_id'])->where('object_type',$r['object_type'])->where('type',$r['type'])->get();
//                 dd($r->all());
                foreach ($data as $highlight)
                {
                    $highlight->loadRelation();
                }
                return response()->json($data);
            }return response()->json("data incomplete");
        }
    }

?>
