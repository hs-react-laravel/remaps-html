<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Api\ApiUser;
use App\Models\Api\ApiLog;
use Illuminate\Support\Facades\RateLimiter;

class PassportCarApiController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next, $guard = null) {
            $token = $request->bearerToken();
            $user = ApiUser::where('api_token', $token)->first();
            if ($user) {
                $executed = RateLimiter::attempt(
                    'send-message:'.$user->id,
                    $perMinute = 5,
                    function() {
                        // Send message...
                    }
                );
                if (!$executed) {
                    return response()->json(['error' => 'Too Many Requests'], 429);
                }
                if (!$user->hasActiveSubscription()) {
                    return response()->json(['error' => 'Invalid Token'], 498);
                }
            } else {
                return response()->json(['error' => 'Invalid Token'], 498);
            }
            return $next($request);
        });
    }

    public function logging($token, $endpoint) {
        $apiUser = ApiUser::where('api_token', $token)->first();
        ApiLog::create([
            'user_id' => $apiUser->id,
            'endpoint' => $endpoint
        ]);
    }

    //
    public function getMakes(Request $request)
    {
        $this->logging($request->bearerToken(), 'makes');
        $brands = Car::groupBy('brand')->pluck('brand');

        $res = array();
        foreach($brands as $b) {
            $logo = asset('images/carlogo/'.str_replace("+", "-", urlencode(strtolower($b))).'.jpg');
            array_push($res, [
                'make' => $b,
                'logo' => $logo
            ]);
        }

        return response()->json($res, 200);
    }

    public function getModels(Request $request)
    {
        $this->logging($request->bearerToken(), 'models');
        $make = request()->make;
        $models = Car::where('brand', $make)
                ->groupBy('model')
                ->pluck('model');

        return response()->json([
            'make' => $make,
            'models' => $models
        ]);
    }

    public function getGenerations(Request $request)
    {
        $this->logging($request->bearerToken(), 'generations');
        $make = request()->make;
        $model = request()->model;
        $generations = Car::where('brand', $make)
                ->where('model', $model)
                ->groupBy('year')
                ->pluck('year');
        return response()->json([
            'make' => $make,
            'model' => $model,
            'generations' => $generations
        ]);
    }

    public function getEngines(Request $request)
    {
        $this->logging($request->bearerToken(), 'engines');
        $make = request()->make;
        $model = request()->model;
        $generation = request()->generation;
        $engines = Car::where('brand', $make)
                ->where('model', $model)
                ->where('year', $generation)
                ->select('engine_type', 'title', 'std_bhp', 'tuned_bhp', 'tuned_bhp_2', 'std_torque', 'tuned_torque', 'tuned_torque_2')
                ->get();
        return response()->json([
            'make' => $make,
            'model' => $model,
            'generation' => $generation,
            'engines' => $engines
        ]);
    }
}
