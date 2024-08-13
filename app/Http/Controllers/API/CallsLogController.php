<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Call_logs;
use App\Http\Resources\Call_logsResource;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CallsLogController extends Controller
{
    //
    public function index()
    {

        $logs = Call_logs::paginate(25);

        return response()->json([
            'status' => true,
            'posts' => $logs
        ]);
    }
    public function userLogs($id)
    {
        $logs = Call_logs::where('user_id',$id);
        $logs = $logs->orderBy('dateTime', 'desc')->paginate(25);
       // $logs = $this->paginate($logs);
        return response()->json([
            'status' => true,
            'message' => "success",
            'logs' => $logs
        ], 200);
    }

    public function callLogs(Request $request)
    {

        $timezone = 'Asia/Dubai';
        // if(Auth::user()->timezone){
        //    // $timezone = Auth::user()->timezone;
        // }
        $year = Carbon::now($timezone)->year;
        if($request->has('year')){
            $year = $request->year;
        }

        $period = Carbon::now()->year;
        $user_id = $request->user_id;
        $userrole = $request->user_role;
        //$agency = Auth::user()->agency;
        $today = Carbon::now($timezone)->toDateString();
        $yesterday = Carbon::yesterday($timezone)->toDateString();
        $current_month = Carbon::now($timezone)->month;
        $lastMonth = Carbon::now($timezone)->subMonth()->format('m');

        //$last_month = Carbon::now()->subMonth()->month;
        //DB::enableQueryLog();
        if($request->period=='daily'){
            $period = $today;
        }
        if($request->period=='yesterday'){
            $period = $yesterday;
        }
        if($request->period=='monthly'){
            $period = $current_month;
        }
        if($request->period=='last_month'){
            $period = $lastMonth;
        }
        if(!$request->period){
            if($userrole ==1 || $userrole ==2  || $userrole ==8){
                $call_logs['all_calls'] = Call_logs::count();
                $call_logs['dialed'] = Call_logs::where('status', 'Dialed call')->distinct('phone')->count('phone');
                $call_logs['answered'] = Call_logs::where('status', 'Dialed call')->where('duration','>',0)->distinct('phone')->count('phone');
                $call_logs['notanswered'] = Call_logs::where('status', 'Dialed call')->where('duration','<',1)->distinct('phone')->count('phone');
                $call_logs['recieved'] = Call_logs::where('status', 'Recieved call')->distinct('phone')->count('phone');
                $call_logs['missed'] = Call_logs::where('status', 'Missed call')->distinct('phone')->count('phone');
                #$call_logs['rejected'] = Call_logs::where('status', 'Rejected call')->distinct('phone')->count('phone');
            } else {
                //$call_logs['all_calls'] = Call_logs::where('user_id',$user_id)->groupBy('phone')->count();
                $call_logs['all_calls']  = Call_logs::where('user_id', '=', $user_id)->distinct('phone')->count('phone');
                $call_logs['dialed'] = Call_logs::where('status', 'Dialed call')->where('user_id',$user_id)->distinct('phone')->count('phone');
                $call_logs['answered'] = Call_logs::where('status', 'Dialed call')->where('duration','>',0)->where('user_id',$user_id)->distinct('phone')->count('phone');
                $call_logs['notanswered'] = Call_logs::where('status', 'Dialed call')->where('duration','<',1)->where('user_id',$user_id)->distinct('phone')->count('phone');
                $call_logs['recieved'] = Call_logs::where('status', 'Recieved call')->where('user_id',$user_id)->distinct('phone')->count('phone');
                $call_logs['missed'] = Call_logs::where('status', 'Missed call')->where('user_id',$user_id)->distinct('phone')->count('phone');
                #$call_logs['rejected'] = Call_logs::where('status', 'Rejected call')->distinct('phone')->count('phone');
            }

        } else {
            if ($userrole ==1 || $userrole ==2 || $userrole  == 8) {
                if($request->period=='daily' || $request->period=='yesterday'){
                    $call_logs['all_calls'] = Call_logs::whereDate('dateTime', '=', $period)->distinct('phone')->count('phone');
                    // $call_logs['all_calls'] = Call_logs::when($period, function ($query) use ($period, $year, $timezone) {
                    //     // Include the timezone in the condition if necessary
                    //     return $query->whereMonth('dateTime', $period)->whereYear('dateTime', $year);
                    // })
                    // ->distinct('phone')
                    // ->count('phone');
                    $call_logs['dialed'] = Call_logs::where('status', 'Dialed call')->whereDate('dateTime', '>=', $period)->distinct('phone')->count('phone');
                    $call_logs['answered'] = Call_logs::where('status', 'Dialed call')->where('duration','>',0)->whereDate('dateTime', '=', $period)->distinct('phone')->count('phone');
                    $call_logs['notanswered'] = Call_logs::where('status', 'Dialed call')->where('duration','<',1)->whereDate('dateTime', '=', $period)->distinct('phone')->count('phone');
                    $call_logs['recieved'] = Call_logs::where('status', 'Recieved call')->whereDate('dateTime', '=', $period)->distinct('phone')->count('phone');
                    $call_logs['missed'] = Call_logs::where('status', 'Missed call')->whereDate('dateTime', '=', $period)->distinct('phone')->count('phone');
                    #$call_logs['rejected'] = Call_logs::where('status', 'Rejected call')->distinct('phone')->count('phone');
                }
                else{
                    $call_logs['all_calls'] = Call_logs::whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->distinct('phone')->count('phone');
                    $call_logs['dialed'] = Call_logs::where('status', 'Dialed call')->whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->distinct('phone')->count('phone');
                    $call_logs['answered'] = Call_logs::where('status', 'Dialed call')->where('duration','>',0)->whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->distinct('phone')->count('phone');
                    $call_logs['notanswered'] = Call_logs::where('status', 'Dialed call')->where('duration','<',1)->whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->distinct('phone')->count('phone');
                    $call_logs['recieved'] = Call_logs::where('status', 'Recieved call')->whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->distinct('phone')->count('phone');
                    $call_logs['missed'] = Call_logs::where('status', 'Missed call')->whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->distinct('phone')->count('phone');
                   # $call_logs['rejected'] = Call_logs::where('status', 'Rejected call')->distinct('phone')->count('phone');
                }

            }else{
                $call_logs['all_calls'] = Call_logs::whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->where('user_id',$user_id)->distinct('phone')->count('phone');
                $call_logs['dialed'] = Call_logs::where('status', 'Dialed call')->whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->where('user_id',$user_id)->distinct('phone')->count('phone');
                $call_logs['answered'] = Call_logs::where('status', 'Dialed call')->where('duration','>',0)->where('user_id',$user_id)->whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->distinct('phone')->count('phone');
                $call_logs['notanswered'] = Call_logs::where('status', 'Dialed call')->where('duration','<',1)->where('user_id',$user_id)->whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->distinct('phone')->count('phone');
                $call_logs['recieved'] = Call_logs::where('status', 'Recieved call')->whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->distinct('phone')->where('user_id',$user_id)->count('phone');
                $call_logs['missed'] = Call_logs::where('status', 'Missed call')->whereMonth('dateTime', '=', $period)->whereYear('dateTime', $year)->where('user_id',$user_id)->distinct('phone')->count('phone');
                #$call_logs['rejected'] = Call_logs::where('status', 'Rejected call')->distinct('phone')->count('phone');
            }

        }
        //event(new NewCallLogEvent($call_logs));
        // if($request->has('user_id')){
        //     $result = Lead::search($request->lead_search)
        //         ->paginate(10);
        // }
        //$quries = DB::getQueryLog();
        return response()->json([
            'message' => 'Success',
            'period'=> $period,
            //'query'=> $quries,
            'call_logs'=> $call_logs
        ]);

    }

    public function call_logs_users(Request $request){
        $timezone = 'Asia/Dubai';
        if(!empty(Auth::user()->timezone)){
            $timezone = Auth::user()->timezone;
        }
        $year = Carbon::now($timezone)->year;
        if($request->has('year')){
            $year = $request->year;
        }
        //$agency = Auth::user()->agency;
        $today = Carbon::today($timezone)->toDateString();
        $current_month = Carbon::now($timezone)->month;
        $lastMonth = Carbon::now($timezone)->subMonth()->format('m');
        $yesterday = Carbon::yesterday($timezone);
        DB::enableQueryLog();
        $call_logs = User::query()
            ->join('call_logs', 'users.id', '=', 'call_logs.user_id')
            ->select('users.id')
            ->selectRaw('COUNT(DISTINCT call_logs.phone) as all_calls')
            ->selectRaw('COUNT(DISTINCT CASE WHEN call_logs.status = "Dialed call" THEN call_logs.phone END) as dialed')
            ->selectRaw('COUNT(DISTINCT CASE WHEN call_logs.status = "Recieved call" THEN call_logs.phone END) as received')
            ->selectRaw('COUNT(DISTINCT CASE WHEN call_logs.status = "Dialed call" AND call_logs.duration > 0 THEN call_logs.phone END) as answered')
            ->selectRaw('COUNT(DISTINCT CASE WHEN call_logs.status = "Dialed call" AND call_logs.duration < 1 THEN call_logs.phone END) as notanswered')
            ->selectRaw('COUNT(DISTINCT CASE WHEN call_logs.status = "Missed call" THEN call_logs.phone END) as missed')
            ->selectRaw('COUNT(DISTINCT CASE WHEN call_logs.status = "Rejected call" THEN call_logs.phone END) as rejected')
            ->selectRaw('COUNT(DISTINCT call_logs.phone) as unique_lead_contacts')
            //->where('users.agency', 1)
            //->where('users.status', 1)
            //->where('users.role', 7)
            ->groupBy('users.id');
            if($request->period=='daily'){
                $call_logs = $call_logs->whereDate('call_logs.dateTime', '>=', $today);
            }
            if($request->period=='yesterday'){
                $call_logs = $call_logs->whereDate('call_logs.dateTime', '=', $yesterday);
            }
            if($request->period=='monthly'){
                $call_logs = $call_logs->whereMonth('call_logs.dateTime', '=', $current_month)->whereYear('dateTime', $year);
            }
            if($request->period=='last_month'){
                $call_logs = $call_logs->whereMonth('call_logs.dateTime', '=', $lastMonth)->whereYear('dateTime', $year);
            }
            $call_logs = $call_logs->get();

            // Emit a WebSocket event with the new call logs data
            $channelName = 'call-logs';
            $eventName = 'new-call-logs';
            $payload = json_encode($call_logs);

            try {
                Redis::publish("channel-{$channelName}", json_encode([
                    'event' => $eventName,
                    'data' => $payload,
                ]));
            } catch (\Exception $e) {
                Log::error("Failed to publish WebSocket event: {$e->getMessage()}");
            }

            //$quries = DB::getQueryLog();
        return response()->json([
            'message' => 'Success',
            //'query'=> $quries,
            'call_logs' => $call_logs
        ]);
    }
    public function send_call_logs()
    {
        $logs = Call_logs::all();

        $logs = DB::table('call_logs')->where('', '<>', NULL)->paginate(25);

        return response()->json([
            'status' => true,
            'posts' => $logs
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logs = Call_logs::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "log recorded successfully!",
            'logs' => $logs
        ], 200);
    }

    public function upsert(Request $request){
        if($request->has('data')){
            $event = $request->data;
        }else{
            $event = $request->all();

        }
        $event = array_unique($event, SORT_REGULAR);
        $event = array_filter($event, fn ($value) => !is_null($value));
        $validator = Validator::make($event, [
            '*.dateTime' => 'required|date_format:Y-m-d H:i:s',
            '*.duration' => 'required',
            '*.phone' => 'required',
            '*.user_id' => 'required',

        ]);
        if($validator->fails()){

            return response()->json([
                'status' => false,
                'message' => "cannot upload the data !",
                'error' => $validator->errors()
            ], 200);
            //return $this->sendError('Validation Error.', $validator->errors());

        }


        foreach ($event as $key => $value) {
            //$logtime = $this->sortTime($value['dateTime']);
            $calllogs =    Call_logs::create([
            'phone' => $value['phone'] ?? '',
            'recording' => $value['recording'] ?? '',
            'dateTime' => date('Y-m-d H:i:s',strtotime($value['dateTime'])) ?? '',
            //'dateTime' => $value['dateTime'] ?? '',
            'duration' => $value['duration'] ?? null,
            'status' => $value['status'] ?? '',
            //'user_id' => Auth::user()->id,
            'user_id' => $value['user_id'] ?? '' ]);
           //$quries = DB::getQueryLog();
        }
        //return $data;
        //$logs = Call_logs::upsert($data, ['dateTime', 'user_id'], ['user_id','lead_id','phone','recording','dateTime','duration','status']
        //);

        return response()->json([
            'status' => true,
            'message' => "logs recorded successfully!",
            //'queries' => $quries,
            'lead' => $event
        ], 200);

    }

    private function sortTime($value){

        $date = new DateTime(strtotime($value));
        $date = $date->format('Y-m-d H:i:s');
        //return date('Y-m-d H:i:s', strtotime($value));
        return $date;
    }

    private function array_has_dupes($array) {
        // streamline per @Felix
        return count($array) !== count(array_unique($array));
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Call_logs  $Call_logs
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Call_logs = Call_logs::find($id);

        if (is_null($Call_logs)) {
            return response()->json([
                'status' => false,
                'message' => "Not Found !",
            ], 200);
           // return $this->sendError('No call history found.');
        }

        return $this->sendResponse(new Call_logsResource($Call_logs), 'Log retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Call_logs  $Call_logs
     * @return \Illuminate\Http\Response
     */
    public function edit(Call_logs $Call_logs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Call_logs  $Call_logs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Call_logs $Call_logs)
    {
        $validator = Validator::make($request->all(), [

            'user_id' => 'required',
            'dateTime' => 'required',
            'duration' => 'required',
            'phone' => 'required',

        ]);


       // dd($request->all());
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => "cannot update the data !",
                'error' => $validator->errors()
            ], 200);
            //return $this->sendError('Validation Error.', $validator->errors());

        }

        $Call_logs->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "Logs Updated successfully!",
            'lead' => $Call_logs
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Call_logs  $Call_logs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call_logs $Call_logs)
    {
        $Call_logs->delete();

        return response()->json([
            'status' => true,
            'message' => "Log Deleted successfully!",
        ], 200);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        //$items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
