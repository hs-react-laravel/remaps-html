<?php

namespace App\Http\Controllers\Remaps;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;
    protected $company;

    public function __construct() {
        $this->middleware(function ($request, $next, $guard = null) {
            $this->user = auth()->user();
            if($this->user){
                $this->company = $this->user->company;
                $this->user->last_login = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
                $this->user->save();
            }
            return $next($request);
        });
    }
}
