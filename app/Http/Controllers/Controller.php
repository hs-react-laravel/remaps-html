<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth, Config;

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

                Config::set('mail.driver', $this->company->mail_driver);
                Config::set('mail.host', $this->company->mail_host);
                Config::set('mail.port', $this->company->mail_port);
				Config::set('mail.encryption', $this->company->mail_encryption);
				//Config::set('mail.encryption', '');
                Config::set('mail.username', $this->company->mail_username);
                Config::set('mail.password', $this->company->mail_password);
                Config::set('mail.from.address',$this->company->mail_username );
                Config::set('mail.from.name', $this->company->name);
                Config::set('app.name', $this->company->name);
                Config::set('backpack.base.project_name', $this->company->name);

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
