<?php

    namespace App;
    use Carbon\Carbon;
    use Illuminate\Http\Request;


    define('WINERY_FLAG',3);
    define('WINE_FLAG',2);

    define('HIGHLIGHTED',1);
    define('RECOMMENDED',2);
    class Highlight extends BaseModel
    {
        protected $table='highlight';

        public $fillable=[
            'object_id',
            'object_type',//  2 za vino
                          //  3 za vinariju
            'start_date',
            'end_date',
            'type',       //    2 za preporuceno (RECOMMENDED)
                         //     1 za omiljeno  (HIGHLIGHTED)
            'status'
        ];
//         protected $rules=[
//             'start_date'=>'date_format:Y-m-d H:i:s',
//         ];

        public $timestamps = false;
        protected $created_at=false;
        protected $updated_at=false;

//         protected $dates = [
//             'start_date',
//             'end_date'
//         ];
        protected $primaryKey='id';
        protected $obj_id;
        protected $obj_flag;

        public function checkAndModify($id=null,$object_flag=null)
        {
            if($id!==null && $object_flag!==null)
            {
                $selfInstance=static::where('object_id',$id)->where('object_type',$object_flag)->get();
                $data=['object_id'=>$id,'object_type'=>$object_flag];
                $highlighted=$selfInstance->where('type',HIGHLIGHTED)->first();
                if($highlighted!==null)
                {
                    $data['type']=1;
                   if($selfInstance && isset($selfInstance->start_date) && isset($selfInstance->end_date)  && $selfInstance->expired()){
                   $relationInstance=$highlighted->loadRelations();
                        $selfInstance->status=0;
                        $relationInstance->highlighted=0;
                        $selfInstance->save();
                        $relationInstance->save();
                   }

                }
                $recommended=$selfInstance->where('type',RECOMMENDED)->first();
                if($recommended!==null)
                {
                    \Log::info("RECOMMENDED: ",(array)($recommended));
                    $relationInstance=$recommended->loadRelations();
                    $data['type']=RECOMMENDED;
                    $selfInstance= static::checkExists($data);
                    // \Log::info("Self instance",['instanca'=>(array)($selfInstance)]);
                    // \Log::info("Datum je istekao/nije",['istekao'=>$selfInstance->expired(),'vino'=>$relationInstance->toArray()]);
                    if($selfInstance && isset($selfInstance->start_date) && isset($selfInstance->end_date) && $selfInstance->expired()){
                        $selfInstance->status=0;
                        $relationInstance->recommended=0;
                        $selfInstance->save();
                        $relationInstance->save();
                    }
                }
            }
        }

        public static function storeOrChange(Request $r)
        {
            $instance=new HighLight;
            $data=$r->only(['object_id','object_type','start_date','end_date','type','status']);
            $exists=static::checkExists($data);
            if($exists && $exists->object_id!==null)
            {
                static::removeDuplicates($data);
                $instance=static::findOrFail($exists->id);
                if($data['start_date']!==null)
                {
                    $instance->start_date= new Carbon(date($data['start_date']));
                }
                if($data['end_date']!==null)
                {
                    $instance->end_date= new Carbon(date($data['end_date']));
                }
                $instance->status=$data['status'];
//                 dd($instance->end_date);
                \Log::info('Zahtjev za create Marketing-a',(array)$r->all());
                if(! $instance->save())
                    return response()->json(['message'=>'Cannot update'],404);
                $instance->makeExpanded($data);

                return response()->json(['message' => "Succesifully updated"]);

            }else{
                $success= Highlight::insert((array)($data));
                if($success)
                {
                        $instance=static::all()->where('object_id',$data['object_id'])->where('object_type',$data['object_type'])->first();

//                              $instance->modifyRelations($data);
                             $instance->makeExpanded($data);
                    $instance->status=$data['status'];
                    if($instance->save())
                        return response()->json(['message'=>"Succesifully created"]);
                    else return response()->json(['message'=>"Error"]);
                }else {
                    return response()->json(['message'=>'Error',404]);
                }

            }
        }

        public static function removeDuplicates($data)
        {
            $q= static::where('object_id',$data['object_id'])->where('object_type',$data['object_type'])->where('type',$data['type']);
            $data= $q->get();
            $first= $q->first();
            if($data->count()>1) {
                foreach($data as $single) {
                    if($single->id!==$first->id)
                        $single->delete();
                }
            }
        }

        public function getExpanded()
        {
             if($this->object_type==WINE_FLAG)
                return '\App\Wine';
             if($this->object_type==WINERY_FLAG)
                return'\App\Winery';
        }

        public function getExpandedClass()
        {
            if($this->object_type==WINE_FLAG)
                return '\App\Wine';
            if($this->object_type==WINERY_FLAG)
                return'\App\Winery';
        }

        public function checkExpanded()
        {
            $instance=$this->getExpandedClass();
                $this->checkInstance($instance);
        }

        public function checkInstance($instance)
        {
//             dd($this);
            $object=$instance::find($this->obj_id);
            if($this->type==HIGHLIGHTED)
                $object->highlighted=$this->status;
            if($this->type==RECOMMENDED)
                $object->recommended=$this->status;
            $object->save();
        }

        public function makeExpanded($data)
        {
            $class=$this->getExpandedClass();
            $instance=$class::find($this->object_id);
//             dd($data['type']==RECOMMENDED);
            if($data['type']==HIGHLIGHTED){
                $instance->highlighted=$data['status'];
            }
            if($data['type']==RECOMMENDED){
                $instance->recommended=$data['status'];
            }
            return $instance->save();
        }

         public function expired() {
             $now=Carbon::now();
             if($this->start_date!==null && $this->end_date!==null && isset($this->start_date) && isset($this->end_date))
             {
                $startdate=new Carbon(date($this->start_date));
                $enddate=new Carbon( date($this->end_date) );

                $now=Carbon::now();
                // if time is not expired
                if( $now->lt( $enddate ) && $now->gt($startdate)){
                    return 0;
                }
                return 1;
             }

             return 1;
         }

        public static function checkExists($newData)
        {
            $exists= Highlight::all()->where('object_id',$newData['object_id'])->where('object_type',$newData['object_type'])->where('type',$newData['type'])->first();
            return ($exists && $exists!==null)?$exists:false;
        }

        public static function getAll()
        {
            $data=static::all();
            foreach ($data as $marketing)
            {
                $marketing->loadRelation();
            }
            return $data;
        }

        public function loadRelation()
        {
            if($this->object_type== WINE_FLAG)
            {
                $this->wine= Wine::where('id',$this->object_id)->get();
            }
            if($this->object_type== WINERY_FLAG)
            {
                $this->winery= Winery::where('id',$this->object_id)->get();
            }
            return $this;
        }
        public function loadRelations()
        {
            $relation=null;
            if($this->object_type==2)
            {
                $relation= Wine::where('id',$this->object_id)->first();
            }
            if($this->object_type==3)
            {
                $relation= Winery::where('id',$this->object_id)->first();
            }
            return $relation;
        }

        public function modifyRelations($data)
        {
            if($this->object_type== WINE_FLAG)
                $instance= Wine::find($this->object_id);
            if($this->object_type== WINERY_FLAG)
                $instance= Winery::find($this->object_id);
            if($this->type== HIGHLIGHTED)
                $instance->highlighted=$data['status'];
            else if($this->type== RECOMMENDED)
                $instance->recommended=$data['status'];
            if($instance->save())
                return true;
            return false;
        }

        public function checktoExpand()
        {
            $instance=$this->getExpandedClass();
            $this->checkInstance($instance);
        }

        public function changeHighlightedStatus()
        {
            $relation= $this->loadRelations();
            if($relation==null){
                // delete this model
                // if wine or winery
                // does not exists
                $this->delete();
                return false;
            }

            switch($this->type)
            {
                case HIGHLIGHTED:
                {
                    if($this->status==1 && !$this->expired())
                        $relation->highlighted= $this->status;
                    else $relation->highlighted= 0;
                break;
                }
                case RECOMMENDED:
                {
                    if($this->status==1 && !$this->expired())
                        $relation->recommended= $this->status;
                    else $relation->recommended= 0;
                break;
                }
            }
            return $relation->save();
        }



    }


?>
