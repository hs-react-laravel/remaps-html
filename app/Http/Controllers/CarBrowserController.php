<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Models\Car;
use App\Models\Company;
use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Storage;


class CarBrowserController extends MasterController
{
    public function index()
    {
        $brands = Car::groupBy('brand')->pluck('brand');
        return view('pages.car.index', compact('brands'));
    }

    public function category()
    {
        $make = request()->make;
        $model = request()->model;
        $generation = request()->generation;
        $engine = request()->engine;
        if ($engine) {
            $car = $engines = Car::find($engine);
            $logofile = str_replace(" ", "-", strtolower($car->brand));
            $logofile = asset('images/carlogo/'.$logofile.'.jpg');

            $template = EmailTemplate::where('company_id', $this->user->company->id)->where('label', 'car-data-text')->first(['subject', 'body']);
            $body =$template->body;
            $body = str_replace('##COMPANY_NAME', $this->user->company->name, $body);
            $body = str_replace('##CAR_MODEL', $car->title, $body);

            return view('pages.car.car', compact('car', 'logofile', 'make', 'model', 'generation', 'engine', 'body'));
        } else if ($generation) {
            $engines = Car::where('brand', $make)
                ->where('model', $model)
                ->where('year', $generation)
                ->get();
            $logo = asset('images/carlogo/'.str_replace(" ", "-", strtolower($make)).'.jpg');
            return view('pages.car.category', compact('make', 'model', 'generation', 'engine'))
                ->with('mode', 'generation')
                ->with('subitems', $engines)
                ->with('title', $generation)
                ->with('brand', $make)
                ->with('model', $model)
                ->with('logo', $logo);
        } else if ($model) {
            $generations = Car::where('brand', $make)
                ->where('model', $model)
                ->groupBy('year')
                ->pluck('year');
            $logo = asset('images/carlogo/'.str_replace(" ", "-", strtolower($make)).'.jpg');
            return view('pages.car.category', compact('make', 'model', 'generation', 'engine'))
                ->with('mode', 'model')
                ->with('subitems', $generations)
                ->with('title', $model)
                ->with('brand', $make)
                ->with('logo', $logo);
        } else if ($make) {
            $models = Car::where('brand', $make)
                ->groupBy('model')
                ->pluck('model');
            $logo = asset('images/carlogo/'.str_replace(" ", "-", strtolower($make)).'.jpg');
            return view('pages.car.category', compact('make', 'model', 'generation', 'engine'))
                ->with('mode', 'make')
                ->with('subitems', $models)
                ->with('title', $make)
                ->with('logo', $logo);
        } else {
            $res = array();
            $brands = Car::groupBy('brand')->pluck('brand');
            foreach($brands as $i => $b) {
                array_push($res, [
                    'brand' => $b,
                    'logo' => asset('images/carlogo/'.str_replace(" ", "-", strtolower($b)).'.jpg')
                ]);
            }
            return view('pages.car.brands')->with('brands', $res);
        }
    }

    public function print_customer(Request $request) {
        try{
            $company = Company::find($request->company_id);
            $user = User::find($request->user_id);
            $car = Car::find($request->car_id);
            $stage = $request->stage;
            $base64_image = $request->blob; // your base64 encoded
            list($type, $file_data) = explode(';', $base64_image);
            list(, $file_data) = explode(',', $file_data);
            $data = base64_decode($file_data);
            Storage::put('/public/uploads/graph/'.$car->id.'-'.$stage.'.png', $data);
            $pdf = new Dompdf;
            $pdfName = time().'_car.pdf';
            $options = $pdf->getOptions();
            $options->setIsRemoteEnabled(true);
            $pdf->setOptions($options);

            $template = EmailTemplate::where('company_id', $company->id)->where('label', 'car-data-text')->first(['subject', 'body']);
            $body = $template->body;
            $body = str_replace('##COMPANY_NAME', $company->name, $body);
            $body = str_replace('##CAR_MODEL', $car->title, $body);

            $pdf->loadHtml(
                view('pdf.car')->with([
                    'car' => $car,
                    'stage' => $stage,
                    'company' => $company,
                    'user' => $user,
                    'vehicle' => $request->vehicle_reg,
                    'std_bhp' => $request->std_bhp,
                    'std_torque' => $request->std_torque,
                    'tuned_bhp' => $request->tuned_bhp,
                    'tuned_torque' => $request->tuned_torque,
                    'tuned_bhp_2' => $request->tuned_bhp_2,
                    'tuned_torque_2' => $request->tuned_torque_2,
                ])->render()
            );
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            return $pdf->stream($pdfName);
        }catch(\Exception $e){
            dd($e);
        }
    }
}
