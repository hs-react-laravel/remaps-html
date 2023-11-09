<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Models\User;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\Styling;
use App\Models\Shop\ShopCategory;

class Helper
{
    public static function applClasses($app = '')
    {
        $company = Company::where('v2_domain_link', url(''))->first();
        $DefaultData = [
            'mainLayoutType' => 'vertical',
            'theme' => 'light',
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

        $data = $DefaultData;
        if ($company) {
            $styleObj = Styling::where('company_id', $company->id)->first();
            if ($styleObj) {
                $data = (array)json_decode($styleObj->data);
            } else {
                $data = $DefaultData;
                $newStyle = new Styling;
                $newStyle->company_id = $company->id;
                $newStyle->data = json_encode($DefaultData);
                $newStyle->save();
            }
        }

        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        // $data = array_merge($DefaultData, $data);

        // All options available in the template
        $allOptions = [
            'mainLayoutType' => array('vertical', 'horizontal'),
            'theme' => array('light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'),
            'sidebarCollapsed' => array(true, false),
            'showMenu' => array(true, false),
            'layoutWidth' => array('full', 'boxed'),
            'navbarColor' => array('bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark', 'bg-secondary', 'bg-dblue', 'bg-dgreen', 'bg-soil', 'bg-dred', 'bg-tred'),
            'horizontalMenuType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'),
            'horizontalMenuClass' => array('static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'),
            'verticalMenuNavbarType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'),
            'navbarClass' => array('floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'),
            'footerType' => array('static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'),
            'pageHeader' => array(true, false),
            'contentLayout' => array('default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'),
            'blankPage' => array(false, true),
            'sidebarPositionClass' => array('content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'),
            'contentsidebarClass' => array('content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'),
            'defaultLanguage' => array('en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt'),
            'direction' => array('ltr', 'rtl'),
        ];

        //if mainLayoutType value empty or not match with default options in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
            if (array_key_exists($key, $DefaultData)) {
                if (gettype($DefaultData[$key]) === gettype($data[$key])) {
                    // data key should be string
                    if (is_string($data[$key])) {
                        // data key should not be empty
                        if (isset($data[$key]) && $data[$key] !== null) {
                            // data key should not be exist inside allOptions array's sub array
                            if (!array_key_exists($data[$key], $value)) {
                                // ensure that passed value should be match with any of allOptions array value
                                $result = array_search($data[$key], $value, 'strict');
                                if (empty($result) && $result !== 0) {
                                    $data[$key] = $DefaultData[$key];
                                }
                            }
                        } else {
                            // if data key not set or
                            $data[$key] = $DefaultData[$key];
                        }
                    }
                } else {
                    $data[$key] = $DefaultData[$key];
                }
            }
        }

        //layout classes
        $layoutClasses = [
            'theme' => $data['theme'],
            'layoutTheme' => $allOptions['theme'][$data['theme']],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'showMenu' => $data['showMenu'],
            'layoutWidth' => $data['layoutWidth'],
            'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor' => $data['navbarColor'],
            'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType' => $allOptions['footerType'][$data['footerType']],
            'sidebarClass' => '',
            'bodyClass' => $data['bodyClass'],
            'pageClass' => $data['pageClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType' => $data['mainLayoutType'],
            'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction' => $data['direction'],
        ];
        // set default language if session hasn't locale value the set default language
        if (!session()->has('locale')) {
            app()->setLocale($layoutClasses['defaultLanguage']);
        }

        // sidebar Collapsed
        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = "menu-collapsed";
        }

        // blank page class
        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = "blank-page";
        }

        if ($app === 'ecommerce') {
            $layoutClasses['contentLayout'] = 'content-left-sidebar';
            $layoutClasses['pageClass'] = 'ecommerce-application';
            $layoutClasses['contentsidebarClass'] = 'content-detached content-right';
        }

        if ($app === 'chat') {
            $layoutClasses['contentLayout'] = 'content-left-sidebar';
            $layoutClasses['pageClass'] = 'chat-application';
            $layoutClasses['contentsidebarClass'] = 'content-detached';
        }

        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'demo-4';
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.' . $demo . '.' . $config, $val);
                }
            }
        }
    }

    public static function genColorCodeFromText($text, $min_brightness=100, $spec=10)
    {
        // Check inputs
        // if(!is_int($min_brightness)) throw new Exception("$min_brightness is not an integer");
        // if(!is_int($spec)) throw new Exception("$spec is not an integer");
        // if($spec < 2 or $spec > 10) throw new Exception("$spec is out of range");
        // if($min_brightness < 0 or $min_brightness > 255) throw new Exception("$min_brightness is out of range");


        $hash = md5($text);  //Gen hash of text
        $colors = array();
        for($i=0;$i<3;$i++)
            $colors[$i] = max(array(round(((hexdec(substr($hash,$spec*$i,$spec)))/hexdec(str_pad('',$spec,'F')))*255),$min_brightness)); //convert hash into 3 decimal values between 0 and 255

        if($min_brightness > 0)  //only check brightness requirements if min_brightness is about 100
            while( array_sum($colors)/3 < $min_brightness )  //loop until brightness is above or equal to min_brightness
                for($i=0;$i<3;$i++)
                    $colors[$i] += 10;	//increase each color by 10

        $output = '';

        for($i=0;$i<3;$i++)
            $output .= str_pad(dechex($colors[$i]),2,0,STR_PAD_LEFT);  //convert each color to hex and append to output

        return $output;
    }

    public static function generateAvatarColor($id)
    {
        $user = User::withTrashed()->find($id);
        return static::genColorCodeFromText($user ? $user->fullname : '');
    }

    public static function getInitialName($id)
    {
        $user = User::withTrashed()->find($id);
        return $user ? mb_strtoupper(mb_substr($user->first_name, 0, 1) . mb_substr($user->last_name, 0, 1)) : '';
    }

    public static function getInitialNameCompany($id)
    {
        $company = Company::find($id);
        $nameParts = explode(' ', trim($company->name));
        $firstName = array_shift($nameParts);
        $lastName = array_shift($nameParts);
        return mb_substr($firstName, 0, 1).mb_substr($lastName, 0, 1);
    }

    public static function getCurrencySymbol($currencyCode, $locale = 'en_US')
	{
		$formatter = new \NumberFormatter($locale . '@currency=' . $currencyCode, \NumberFormatter::CURRENCY);
		return $formatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
	}

    public static function companyTimeZone()
    {
        $company = Company::where('v2_domain_link', url(''))->first();
        return $company->timezone;
    }

    public static function categoryTree($company_id, $mode = 'all', $selected = [])
    {
        $categories = ShopCategory::where('company_id', $company_id)->get()->toArray();
        $roots = [];
        if ($mode == 'all') {
            $roots = ShopCategory::where('parent_category', 0)->get()->toArray();
        } else if ($mode == 'tool') {
            $roots = ShopCategory::where('id', 1)->get()->toArray();
        } else if ($mode == 'digital') {
            $roots = ShopCategory::where('id', 2)->get()->toArray();
        }
        $categories = array_merge($categories, $roots);
        $tree = function ($elements, $parentId = 0) use (&$tree, $selected) {
            $branch = array();
            foreach ($elements as $element) {
                if ($element['parent_category'] == $parentId) {
                    $children = $tree($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    } else {
                        $element['children'] = [];
                    }
                    $element['text'] = $element['name'];
                    $element['state'] = [
                        'opened' => true
                    ];
                    if ($selected != null && in_array($element['id'], $selected)) {
                        $element['state'] = [
                            'opened' => true,
                            'checked' => true,
                        ];
                    }
                    $branch[] = $element;
                }
            }
            return $branch;
        };
        $tree = $tree($categories);
        return $tree;
    }
}
