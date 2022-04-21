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
use App\Models\NotificationRead;

class MasterController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;
    protected $company;
    protected $role;
    protected $is_evc;
    protected $tickets;

    protected function check_master() {
        if ($this->company->id != 1)
            abort(403);
    }

    public function __construct() {
        $this->middleware(function ($request, $next, $guard = null) {
            try {
                $this->company = Company::where('v2_domain_link', url(''))->first();
                if (str_starts_with($request->path(), 'admin')) {
                    $user = null;
                    if ($this->company->id == 1) { // master
                        $user = Auth::guard('master')->user();
                    } else {
                        $user = Auth::guard('admin')->user();
                    }
                    if ($user) $this->user = $user;
                    else return redirect(url('admin/login'));
                } else if (str_starts_with($request->path(), 'customer')) {
                    $user = Auth::guard('customer')->user();
                    if ($user) $this->user = $user;
                    else return redirect(url('login'));
                } else if (str_starts_with($request->path(), 'staff')) {
                    $user = Auth::guard('staff')->user();
                    if ($user) $this->user = $user;
                    else return redirect(url('login'));
                }

                if($this->user){
                    $this->user->last_login = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
                    $this->user->save();
                    $this->is_evc = !!$this->company->reseller_id;
                    $this->tickets = $this->user->unread_tickets;

                    if ($this->company->mail_host && $this->company->mail_port
                        && $this->company->mail_username && $this->company->mail_password) {
                        Config::set('mail.default', $this->company->mail_driver);
                        Config::set('mail.mailers.smtp.host', $this->company->mail_host);
                        Config::set('mail.mailers.smtp.port', $this->company->mail_port);
                        Config::set('mail.mailers.smtp.encryption', $this->company->mail_encryption);
                        Config::set('mail.mailers.smtp.username', $this->company->mail_username);
                        Config::set('mail.mailers.smtp.password', $this->company->mail_password);
                        Config::set('mail.from.address',$this->company->mail_username );
                    } else {
                        Config::set('mail.default', 'smtp');
                        Config::set('mail.mailers.smtp.host', 'mail.remapdash.com');
                        Config::set('mail.mailers.smtp.port', 25);
                        Config::set('mail.mailers.smtp.encryption', '');
                        Config::set('mail.mailers.smtp.username', 'no-reply@remapdash.com');
                        Config::set('mail.mailers.smtp.password', '6%3d5ohF');
                        Config::set('mail.from.address', 'no-reply@remapdash.com');
                    }

                    Config::set('mail.from.name', $this->company->name);
                    Config::set('app.name', $this->company->name);

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
                    view()->share('tickets_count', $this->tickets);

                    $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/'.$verticalMenu));
                    $verticalMenuData = json_decode($verticalMenuJson);
                    $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/'.$horizontalMenu));
                    $horizontalMenuData = json_decode($horizontalMenuJson);

                    if ($this->company->reseller_id && $this->user->is_admin) {
                        $evc_menu = new \stdClass();
                        $evc_menu->url = "admin/evc-tuning-credits";
                        $evc_menu->name = "menu_EVCTuningCredit";
                        $evc_menu->icon = "dollar-sign";
                        $evc_menu->slug = "evc-tuning-credits.index";
                        array_splice($verticalMenuData->menu, 9, 0, [$evc_menu]);
                    }

                    if ($this->role == 'customer') {
                        $notifies = array_filter($this->user->notifies->toArray(), function($obj){
                            $readObj = NotificationRead::where('notification_id', $obj['id'])->where('user_id', $this->user->id)->first();
                            if ($readObj->is_read == 1) {
                                return false;
                            }
                            return true;
                        });
                        view()->share('notifies', $notifies);
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
                    if ($styleObj) {
                        $data = (array)json_decode($styleObj->data);
                    }
                    view()->share('styling', $data);
                }
            } catch (\Exception $ex) {
                session()->flash('error', $ex->getMessage());
            }
            return $next($request);
        });
    }
}
