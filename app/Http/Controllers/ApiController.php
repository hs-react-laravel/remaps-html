<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Helpers\Helper;
use App\Models\TuningType;
use App\Models\Car;
use App\Models\ChatMessage;
use App\Models\Company;
use App\Models\Styling;
use App\Models\User;
use App\Models\FileService;
use App\Models\Shop\ShopCategory;

class ApiController extends Controller
{
    //
    public function tuning_type_options($id) {
        return TuningType::find($id)->tuningTypeOptions()->orderBy('order_as')->get();
    }

    public function car_query(Request $request)
    {
        if ($request->model == '') {
            $models = Car::where('brand', $request->make)
                ->groupBy('model')
                ->pluck('model');
            return $models;
        }
        if ($request->generation == '') {
            $generations = Car::where('brand', $request->make)
                ->where('model', $request->model)
                ->groupBy('year')
                ->pluck('year');
            return $generations;
        }
        if ($request->engine == '') {
            $engines = Car::where('brand', $request->make)
                ->where('model', $request->model)
                ->where('year', $request->generation)
                ->get();
            return $engines;
        }
    }

    public function car_id(Request $request)
    {
        $id = Car::where('brand', $request->make)
            ->where('model', $request->model)
            ->where('year', $request->generation)
            ->where('engine_type', $request->engine)
            ->first()->id;
        return $id;
    }

    public function change_style(Request $request)
    {
        $company = Company::find($request->input('company'));
        $styling = Styling::where('company_id', $company->id)->first();
        $styleObj = (array)json_decode($styling->data);
        if ($request->input('type') == 'theme') {
            switch($request->input('value')) {
                case '':
                    $styleObj['theme'] = 'light';
                    break;
                case 'dark-layout':
                    $styleObj['theme'] = 'dark';
                    break;
                case 'semi-dark-layout':
                    $styleObj['theme'] = 'semi-dark';
                    break;
                case 'bordered-layout':
                    $styleObj['theme'] = 'bordered';
                    break;
            }
        } else if ($request->input('type') == 'layoutWidth') {
            $styleObj['layoutWidth'] = $request->input('value');
        } else if ($request->input('type') == 'navbarColor') {
            $styleObj['navbarColor'] = $request->input('value');
        } else if ($request->input('type') == 'navbarType') {
            if ($styleObj['mainLayoutType'] == 'vertical') {
                $styleObj['verticalMenuNavbarType'] = $request->input('value');
            } else if ($styleObj['mainLayoutType'] == 'horizontal') {
                $styleObj['horizontalMenuType'] = $request->input('value');
            }
        } else if ($request->input('type') == 'footerType') {
            $styleObj['footerType'] = $request->input('value');
        }
        $styling->data = json_encode($styleObj);
        $styling->save();
        return $request->input('value');
    }

    public function readShopGuide(Request $request) {
        $company = Company::find($request->id);
        $company->is_first_shop = 1;
        $company->save();
    }

    public function openShop(Request $request) {
        $company = Company::find($request->id);
        $company->is_open_shop = 1;
        $company->save();
    }

    public function sendIM(Request $request) {
        $message = ChatMessage::create($request->all());
        event(new ChatEvent($message));
    }

    public function getAdminUsers(Request $request) {
        $admin = User::find(Company::find($request->company_id)->owner->id);
        $lastMessage = ChatMessage::where('target', $request->user_id)
                ->orderBy('created_at', 'DESC')
                ->first();
        $unreadCt = ChatMessage::where('target', $request->user_id)
            ->orderBy('created_at', 'DESC')
            ->where('is_read', 0)
            ->where('to', 0)
            ->count();
        return [[
            'id' => $admin->id,
            'name' => $admin->first_name.' '.$admin->last_name,
            'msg' => $lastMessage ? $lastMessage->message : '',
            'date' => $lastMessage ? \Carbon\Carbon::parse($lastMessage->created_at)->diffForHumans() : '',
            'count' => $unreadCt,
            'avatar' => [
                'color' => Helper::generateAvatarColor($admin->id),
                'name' => Helper::getInitialName($admin->id)
            ]
        ]];
    }

    public function getChatUsers(Request $request) {
        $messageUserIDs = ChatMessage::where('company_id', $request->company_id)
            ->select('target')
            ->groupBy('target')
            ->pluck('target')
            ->toArray();
        $mUsers = User::whereIn('id', $messageUserIDs)->get();
        $cUsers = User::whereNotIn('id', $messageUserIDs)
            ->where('company_id', $request->company_id)
            ->where('is_admin', '!=', 1)
            ->whereNull('is_staff')
            ->get();

        $mUserRes = array();
        foreach($mUsers as $muser) {
            $lastMessage = ChatMessage::where('target', $muser->id)
                ->orderBy('created_at', 'DESC')
                ->first();
            $unreadCt = ChatMessage::where('target', $muser->id)
                ->orderBy('created_at', 'DESC')
                ->where('is_read', 0)
                ->where('to', 1)
                ->count();
            array_push($mUserRes, [
                'id' => $muser->id,
                'name' => $muser->first_name.' '.$muser->last_name,
                'msg' => $lastMessage->message,
                'date' => \Carbon\Carbon::parse($lastMessage->created_at)->diffForHumans(),
                'count' => $unreadCt,
                'avatar' => [
                    'color' => Helper::generateAvatarColor($muser->id),
                    'name' => Helper::getInitialName($muser->id)
                ]
            ]);
        }

        $cUserRes = array();
        foreach($cUsers as $cuser) {
            array_push($cUserRes, [
                'id' => $cuser->id,
                'name' => $cuser->first_name.' '.$cuser->last_name,
                'avatar' => [
                    'color' => Helper::generateAvatarColor($cuser->id),
                    'name' => Helper::getInitialName($cuser->id)
                ]
            ]);
        }

        return [
            'm' => $mUserRes,
            'c' => $cUserRes
        ];
    }

    public function getChatMessages(Request $request) {
        $day_key = 'Date(created_at)';
        $messageDates = ChatMessage::where('company_id', $request->company_id)
            ->where('target', $request->target)
            ->orderBy('created_at', 'ASC')
            ->groupBy(DB::raw($day_key))
            ->select(DB::raw($day_key))
            ->get();
        $messageGroups = array();
        foreach ($messageDates as $md) {
            $msgs = ChatMessage::where('company_id', $request->company_id)
                ->where('target', $request->target)
                ->where('created_at', 'like', $md->$day_key.'%')
                ->orderBy('created_at', 'ASC')
                ->get();
            $messageGroups[$md->$day_key] = array();
            $groupDir = '';
            $group = array();
            foreach ($msgs as $msg) {
                if ($msg->to != $groupDir && count($group) > 0) {
                    array_push($messageGroups[$md->$day_key], $group);
                    $group = array($msg);
                } else {
                    array_push($group, $msg);
                }
                $groupDir = $msg->to;
            }
            array_push($messageGroups[$md->$day_key], $group);
        }

        $company = Company::find($request->company_id);
        $unreadCt = ChatMessage::where('company_id', $request->company_id)
            ->where('target', $request->target)
            ->where('to', 0)
            ->where('is_read', 0)
            ->count();

        return [
            'message' => $messageGroups,
            'avatarU' => [
                'color' => Helper::generateAvatarColor($request->target),
                'name' => Helper::getInitialName($request->target)
            ],
            'avatarC' => [
                'color' => Helper::generateAvatarColor($company->owner->id),
                'name' => Helper::getInitialNameCompany($request->company_id)
            ],
            'unreadCt' => $unreadCt
        ];
    }

    public function readAll(Request $request) {
        ChatMessage::where('company_id', $request->company_id)
            ->where('target', $request->target)
            ->where('to', $request->to)
            ->update([
                'is_read' => 1
            ]);
    }

    public function unreadCount(Request $request) {
        $user = User::find($request->user_id);
        return $user->unread_chats;
    }

    public function uploadDigital(Request $request) {
        if($request->hasFile('file')){
            if($request->file('file')->isValid()){
                $file = $request->file('file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $org_filename = $file->getClientOriginalName();
                if($file->move(storage_path('app/public/uploads/products/digital/'), $filename)){
                    return response()->json([
                        'status'=> TRUE,
                        'file' => $filename,
                        'remain' => $org_filename
                    ], 200);
                }else{
                    return response()->json(['status'=> FALSE], 404);
                }
            }else{
                return response()->json(['status'=> FALSE], 404);
            }
        }else{
            return response()->json(['status'=> FALSE], 404);
        }
    }

    public function currentTree(Request $request) {
        $categories = ShopCategory::where('company_id', $request->company_id)->get()->toArray();
        $roots = ShopCategory::where('parent_category', 0)->get()->toArray();
        $categories = array_merge($categories, $roots);
        $tree = function ($elements, $parentId = 0) use (&$tree) {
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
                    $branch[] = $element;
                }
            }
            return $branch;
        };
        $tree = $tree($categories);
        return $tree;
    }

    public function createShopCategory(Request $request) {
        ShopCategory::create($request->all());
        return $this->currentTree($request);
    }

    public function deleteShopCategory(Request $request) {
        ShopCategory::find($request->id)->delete();
        return $this->currentTree($request);
    }

    public function updateParentShopCategory(Request $request) {
        ShopCategory::whereIn('id', $request->ids)->update([
            'parent_category' => $request->parent_category
        ]);
    }
}
