<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use App\Models\Styling;
use App\Models\Company;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;
    protected $company;
    protected $role;
    protected $is_evc;

    public function __construct() {
        $this->middleware(function ($request, $next, $guard = null) {
            try {
                // dd($guard);
                $this->user = Auth::guard($guard)->user();
                if($this->user){
                    $this->company = $this->user->company;
                } else {
                    $this->company = Company::where('domain_link', url(''))->first();
                    $this->user = $this->company->owner;
                }

                $this->user->last_login = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
                $this->user->save();
                $this->is_evc = !!$this->company->reseller_id;

                if ($this->company->mail_host && $this->company->mail_port && $this->company->mail_encryption
                    && $this->company->mail_username && $this->company->mail_password) {
                    Config::set('mail.driver', $this->company->mail_driver);
                    Config::set('mail.host', $this->company->mail_host);
                    Config::set('mail.port', $this->company->mail_port);
                    Config::set('mail.encryption', $this->company->mail_encryption);
                    Config::set('mail.username', $this->company->mail_username);
                    Config::set('mail.password', $this->company->mail_password);
                } else {
                    Config::set('mail.driver', 'smtp');
                    Config::set('mail.host', 'mail.myremaps.com');
                    Config::set('mail.port', 25);
                    Config::set('mail.encryption', '');
                    Config::set('mail.username', 'noreply@myremaps.com');
                    Config::set('mail.password', '!Winston11!');
                }

                Config::set('mail.from.address',$this->company->mail_username );
                Config::set('mail.from.name', $this->company->name);
                Config::set('app.name', $this->company->name);
                Config::set('backpack.base.project_name', $this->company->name);

                $verticalMenu = 'verticalMenuCustomer.json';
                $horizontalMenu = 'horizontalMenuCustomer.json';
                $role = 'customer';
                if ($this->user->is_staff) {
                    $verticalMenu = 'verticalMenuStaff.json';
                    $horizontalMenu = 'horizontalMenuStaff.json';
                    $role = 'staff';
                }
                if ($this->user->is_admin) {
                    $verticalMenu = 'verticalMenuCompany.json';
                    $horizontalMenu = 'horizontalMenuCompany.json';
                    $role = 'company';
                }
                if ($this->user->is_master) {
                    $verticalMenu = 'verticalMenu.json';
                    $horizontalMenu = 'horizontalMenu.json';
                    $role = 'master';
                }
                $this->role = $role;

                view()->share('user', $this->user);
                view()->share('company', $this->company);
                view()->share('role', $this->role);
                view()->share('is_evc', $this->is_evc);

                $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/'.$verticalMenu));
                $verticalMenuData = json_decode($verticalMenuJson);
                $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/'.$horizontalMenu));
                $horizontalMenuData = json_decode($horizontalMenuJson);

                if ($this->company->reseller_id && $this->user->is_admin) {
                    $evc_menu = new \stdClass();
                    $evc_menu->url = "admin/evc-tuning-credits";
                    $evc_menu->name = "EVC Tuning Credit Prices";
                    $evc_menu->icon = "dollar-sign";
                    $evc_menu->slug = "evc-tuning-credits.index";
                    array_splice($verticalMenuData->menu, 9, 0, [$evc_menu]);
                }

                // Share all menuData to all the views
                view()->share('menuData', [$verticalMenuData, $horizontalMenuData]);

                $data = [
                    'mainLayoutType' => 'vertical',
                    'theme' => 'dark',
                    'sidebarCollapsed' => false,
                    'navbarColor' => '',
                    'horizontalMenuType' => 'floating',
                    'verticalMenuNavbarType' => 'floating',
                    'footerType' => 'static',
                    'layoutWidth' => 'full',
                    'showMenu' => true,
                    'bodyClass' => '',
                    'pageClass' => '',
                    'pageHeader' => true,
                    'contentLayout' => 'default',
                    'blankPage' => false,
                    'defaultLanguage' => 'en',
                    'direction' => 'ltr',
                ];
                $styleObj = Styling::where('company_id', $this->company->id)->first();
                if (!$styleObj) {
                    $data = (array)json_decode($styleObj->data);
                }
                view()->share('styling', $data);
            } catch (\Exception $ex) {
                session()->flash('error', $ex->getMessage());
            }
            return $next($request);
        });
    }
}
