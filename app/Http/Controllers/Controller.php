<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;
    protected $company;
    protected $role;

    public function __construct() {
        $this->middleware(function ($request, $next, $guard = null) {
            $this->user = Auth::guard($guard)->user();
            if($this->user){
                $this->company = $this->user->company;
                $this->user->last_login = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
                $this->user->save();


                $verticalMenu = 'verticalMenuCustomer.json';
                $role = 'customer';
                if ($this->user->is_staff) {
                    $verticalMenu = 'verticalMenuStaff.json';
                    $role = 'staff';
                }
                if ($this->user->is_admin) {
                    $verticalMenu = 'verticalMenuCompany.json';
                    $role = 'company';
                }
                if ($this->user->is_master) {
                    $verticalMenu = 'verticalMenu.json';
                    $role = 'master';
                }
                $this->role = $role;

                view()->share('user', $this->user);
                view()->share('company', $this->company);
                view()->share('role', $this->role);

                $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/'.$verticalMenu));
                $verticalMenuData = json_decode($verticalMenuJson);
                $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/horizontalMenu.json'));
                $horizontalMenuData = json_decode($horizontalMenuJson);

                // Share all menuData to all the views
                view()->share('menuData',[$verticalMenuData, $horizontalMenuData]);
            }
            return $next($request);
        });
    }
}
