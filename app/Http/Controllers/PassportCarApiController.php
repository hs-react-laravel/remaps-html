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
        $brands = Car::groupBy('brand')->get();

        $res = array();
        foreach($brands as $b) {
            $logo = asset('images/carlogo/'.str_replace("+", "-", urlencode(strtolower($b))).'.jpg');
            array_push($res, [
                'id' => $b->id,
                'make' => $b->brand,
                'logo' => $b->logo
            ]);
        }

        return response()->json($res, 200);
    }
    public function getMake(Request $request, $id)
    {
        $this->logging($request->bearerToken(), 'make-'.$id);
        $car = Car::find($id);
        if (!$car) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $res = new \stdClass();
        $res->id = $car->id;
        $res->make = $car->brand;
        $res->logo = $car->logo;

        return response()->json($res, 200);
    }

    public function getModels(Request $request, $mid)
    {
        $this->logging($request->bearerToken(), 'models');

        $car = Car::find($mid);
        if (!$car) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $models = Car::where('brand', $car->brand)->groupBy('model')->get();
        $res = array();
        foreach($models as $m) {
            array_push($res, [
                'id' => $m->id,
                'make' => $m->brand,
                'model' => $m->model
            ]);
        }

        return response()->json($res, 200);
    }

    public function getModel(Request $request, $nid)
    {
        $this->logging($request->bearerToken(), 'model-'.$nid);

        $car = Car::find($nid);
        if (!$car) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $model = new \stdClass();
        $model->id = $car->id;
        $model->make = $car->brand;
        $model->model = $car->model;

        return response()->json($model, 200);
    }

    public function getGenerations(Request $request, $nid)
    {
        $this->logging($request->bearerToken(), 'generations');

        $car = Car::find($nid);
        if (!$car) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $generations = Car::where('brand', $car->brand)
            ->where('model', $car->model)
            ->groupBy('year')->get();

        $res = array();
        foreach($generations as $g) {
            array_push($res,  [
                'id' => $g->id,
                'make' => $g->brand,
                'model' => $g->model,
                'generation' => $g->year
            ]);
        }
        return response()->json($res, 200);
    }

    public function getGeneration(Request $request, $gid)
    {
        $this->logging($request->bearerToken(), 'generation-'.$gid);

        $car = Car::find($gid);
        if (!$car) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $generation = new \stdClass();
        $generation->id = $car->id;
        $generation->make = $car->brand;
        $generation->model = $car->model;
        $generation->generation = $car->year;

        return response()->json($generation, 200);
    }

    public function getEngines(Request $request, $gid)
    {
        $this->logging($request->bearerToken(), 'engines');

        $car = Car::find($gid);
        if (!$car) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $engines = Car::where('brand', $car->brand)
            ->where('model', $car->model)
            ->where('year', $car->year)
            ->groupBy('engine_type')
            ->orderBy('id')->get();

        $res = array();
        foreach($engines as $g) {
            array_push($res,  [
                'id' => $g->id,
                'make' => $g->brand,
                'model' => $g->model,
                'generation' => $g->year,
                'engine' => $g->engine_type,
                'std_bhp' => $g->std_bhp,
                'tuned_bhp' => $g->tuned_bhp,
                'tuned_bhp_2' => $g->tuned_bhp_2,
                'std_torque' => $g->std_torque,
                'tuned_torque' => $g->tuned_torque,
                'tuned_torque_2' => $g->tuned_torque_2,
            ]);
        }

        return response()->json($res, 200);
    }

    public function getEngine(Request $request, $eid)
    {
        $this->logging($request->bearerToken(), 'engine-'.$eid);

        $car = Car::find($eid);
        if (!$car) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $engine = new \stdClass();
        $engine->id = $car->id;
        $engine->make = $car->brand;
        $engine->model = $car->model;
        $engine->generation = $car->year;
        $engine->engine = $car->engine_type;
        $engine->std_bhp = $car->std_bhp;
        $engine->tuned_bhp = $car->tuned_bhp;
        $engine->tuned_bhp_2 = $car->tuned_bhp_2;
        $engine->std_torque = $car->std_torque;
        $engine->tuned_torque = $car->tuned_torque;
        $engine->tuned_torque_2 = $car->tuned_torque_2;
        $engine->title = $car->title;

        return response()->json($engine, 200);
    }
}
