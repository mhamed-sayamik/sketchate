<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\PriceRange;
use App\Models\Project;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

class ClientController extends Controller
{
    //
    public function dashboard(): View{
        $projects = Project::where('user_id', auth()->user()->id)->orderBy('deadline','asc')->paginate(20);
        return view("client.dashboard", ["projects"=>$projects]);
    }
    public function newProject(){
        $priceRanges = PriceRange::all();
        $categories = Category::all();
        return view("client.new-project", ["categories" => $categories, "priceRanges"=>$priceRanges]);
    }
    public function storeProject(Request $request){
        $validator = validator($request->all(),[
        'milkyah_file' => ['required', 'file',File::types(['pdf', 'png', 'jpeg', 'jpg'])->max(4 * 1024)],
        'krooky_file' => ['required', 'file',File::types(['pdf', 'png', 'jpeg', 'jpg'])->max(4 * 1024)],
        'owner_id_file' => ['required', 'file',File::types(['pdf', 'png', 'jpeg', 'jpg'])->max(4 * 1024)],
        'spaceName0' => 'required|string',
        'spaceDesc0' => 'required|string',
        'spaceArea0' => 'required|numeric|integer',
        'spaceFloor0' => 'required|integer|min:0|max:50',
        'price-range' => 'required|integer|exists:price_ranges,id',
        'deadline' => 'required|date|after:now',
        'inputsN' => 'required|numeric|integer|min:1|max:100',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //files
        $milkyah_file = $request->file('milkyah_file')->store('milkyah_files','private');
        $krooky_file = $request->file('krooky_file')->store('krooky_files','private');
        $owner_id_file = $request->file('owner_id_file')->store('owner_id_files','private');

        $fields = ['milkyah_file' => $milkyah_file,
                   'krooky_file' => $krooky_file,
                   "owner_id_file" => $owner_id_file
                ];
        //spaces dynamic input validation and handling
        $dynValidation=[];

        for($i=1; $i<$request->inputsN; $i++){
            $dynValidation = $dynValidation + [
                'spaceName'.$i => 'required|string',
                'spaceDesc'.$i => 'required|string',
                'spaceArea'.$i => 'required|numeric|integer',
                'spaceFloor'.$i => 'required|integer|min:0|max:50'
            ];
        }
        $validator = validator($dynValidation);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $spaces = [];
        $aproxArea=0;
        for($i=0; $i<$request->inputsN; $i++){
            $space = [
                'name' => $request->input('spaceName'.$i),
                'description'=>$request->input('spaceDesc'.$i),
                'total_area'=>$request->input('spaceArea'.$i),
                'floor'=>$request->input('spaceFloor'.$i)
            ];
            $spaces[] = new Space($space);
            $aproxArea += intval($request->input('spaceArea'.$i));
        }

        $fields =$fields + [
            'price_range_id' => intval($request->input('price-range')),
            'deadline' => $request->input('deadline'),
            'support_omanian_firms' => $this->checkboxToBool('support_omanian_firms'),
            'user_id'=>auth()->user()->id,
            'aprox-area' => $aproxArea
        ];
        $project = Project::create($fields);
        $project->spaces()->saveMany($spaces);
        //project companies categories
        $categoryIds = array_keys($request->input('categories'));
        $categories = Category::whereIn('id', $categoryIds)->get();
        $project->categories()->saveMany($categories);

        return redirect(route("client.dashboard"))->with('success', 'project created successfuly');
    }

    protected function checkboxToBool($inputName){
    global $request;
    if($request->has($inputName)) return true;
    return false;
    }

    public function project(string $id){
        if (!is_numeric($id) || Project::find(intval($id)) === null) {
            return redirect(route('client.dashboard'))->with('error', 'Invalid parameter value');
        }
        $project = Project::find($id);

        if(!Gate::allows('show_project', $project)) redirect(route('client.dashboard'))->with('error', 'you are not authorized');

        if(Session::has('download')){
            return Storage::download(Session::get('download'), Session::get('downloadName'));
        }
        if($project->winner_company !== null){
            $company = auth()->user()->projects->find($project->id)->companies->find($project->winner_company);
            return view("client.project", ["pro" => $project, "company" => $company]);
        }
        else{
            $companies = auth()->user()->projects->find($project->id)->companies;
        }

        return view("client.project", ["pro" => $project, "companies" =>$companies]);
    }
    public function projectDetails(string $id){
        if (!is_numeric($id) || Project::find(intval($id)) === null) {
            return redirect(route('client.dashboard'))->with('error', 'Invalid parameter value');
        }
        $project = Project::find($id);

        if(!Gate::allows('show_project', $project)) redirect(route('client.dashboard'))->with('error', 'you are not authorized');

        if(Session::has('download')){
            return Storage::download(Session::get('download'), Session::get('downloadName'));
        }
        $companies = auth()->user()->projects->find($project->id)->companies;

        return view("client.project-details", ["pro" => $project]);
    }

    public function downloadPlot(string $id){
        if (!is_numeric($id) || Project::find(intval($id)) === null) {
            return redirect(route('client.dashboard'))->with('error', 'Invalid parameter value');
        }
        $project = Project::find(intval($id));
        if(!Gate::allows('show_project', $project)) redirect(route('client.dashboard'))->with('error', 'you are not authorized');
        Session::flash('download','private/'.$project->krooky_file);
        Session::flash('downloadName','plot');
        return redirect()->back();
    }

    public function downloadContract(string $id, string $company_id){
        if (!is_numeric($id) || Project::find(intval($id)) === null) {
            return redirect(route('client.dashboard'))->with('error', 'Invalid parameter value');
        }
        if (!is_numeric($company_id) || Company::find(intval($company_id)) === null) {
            return redirect(route('client.dashboard'))->with('error', 'Invalid parameter value');
        }
        $project = Project::find(intval($id));
        if(!$project->companies->contains($company_id)) redirect(route('client.dashboard'))->with('error', 'you are not authorized');
        $offer = Company::find(intval($company_id))->projects->find($project->id)->offer;
        if(!Gate::allows('show_project', $project)) redirect(route('client.dashboard'))->with('error', 'you are not authorized');
        Session::flash('download','private/'.$offer->contract_file);
        Session::flash('downloadName','contract_file');
        return redirect()->back();
    }

    public function downloadCompanyFile(string $id, string $company_id){
        if (!is_numeric($id) || Project::find(intval($id)) === null) {
            return redirect(route('client.dashboard'))->with('error', 'Invalid parameter value');
        }
        if (!is_numeric($company_id) || Company::find(intval($company_id)) === null) {
            return redirect(route('client.dashboard'))->with('error', 'Invalid parameter value');
        }
        $project = Project::find(intval($id));
        $company = Company::find(intval($company_id));
        if(!$project->companies->contains($company)) redirect(route('client.dashboard'))->with('error', 'you are not authorized');
        Session::flash('download','private/'.$company->company_file);
        Session::flash('downloadName','company_file');
        return redirect()->back();
    }
    public function chooseOffer(string $id, string $company_id){
        if (!is_numeric($id) || Project::find(intval($id)) === null) {
            return redirect(route('client.dashboard'))->with('error', 'Invalid parameter value');
        }
        if (!is_numeric($company_id) || Company::find(intval($company_id)) === null) {
            return redirect(route('client.dashboard'))->with('error', 'Invalid parameter value');
        }
        $project = Project::find(intval($id));
        if(!$project->companies->contains($company_id)) redirect(route('client.dashboard'))->with('error', 'you are not authorized');
        $offer = Company::find(intval($company_id))->projects->find($project->id)->offer;
        if(!Gate::allows('show_project', $project)) redirect(route('client.dashboard'))->with('error', 'you are not authorized');
        $project->winner_company = $company_id;
        $project->save();
        return redirect()->back()->with('success', 'you choosed '.Company::find(intval($company_id))->name);
    }
}
