<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

use function PHPSTORM_META\type;

class CompanyController extends Controller
{
    //
    public function dashboard(): View{
        //return previous projects (company projects)
        $prev_projects = null;
        if(!Auth()->user()->company->projects->isEmpty()) $prev_projects = Auth()->user()->company->projects->toQuery()->latest()->paginate(30);
        return view("company.dashboard",["projects" => $prev_projects]);
    }

    public function projects(): View{
        //show only projects that match company category
        $projects = null;
        if(!Auth()->user()->company->category->projects->isEmpty()) $projects = Auth()->user()->company->category->projects->diff(Auth()->user()->company->projects)->toQuery()->where('deadline', '>', now())->latest()->paginate(30);
        return view("company.projects",["projects" => $projects]);
    }
    public function buyProject(Request $request){
        $project = Project::where('id', $request->project_id)->first();
        if(!isset($project)) return redirect(route('company.projects'))->with('error', 'this project don\'t exist');
        if($project->deadline <= now()) return redirect(route('company.projects'))->with('error', 'this project expired');
        if (!Gate::allows('buy_project', $project)) return redirect(route('company.projects'))->with('error', 'sorry you are not allowed to buy this project');

        Auth()->user()->company->projects()->save($project);
        return redirect(route('company.dashboard'))->with('success', 'project added to company successfuly');
    }
    public function project(string $id){
        if (!is_numeric($id) || Project::find(intval($id)) === null) {
            return redirect(route('company.dashboard'))->with('error', 'Invalid parameter value');
        }
        $project = Project::find($id);

        if(!Gate::allows('show_project', $project)) redirect(route('company.dashboard'))->with('error', 'you are not authorized');

        if(Session::has('download')){
            return Storage::download(Session::get('download'), Session::get('downloadName'));
        }

        $offer = auth()->user()->company->projects->find($project->id)->offer;

        return view("company.project", ["pro" => $project, "offer" =>$offer]);
    }

    public function downloadPlot(string $id){
        if (!is_numeric($id) || Project::find(intval($id)) === null) {
            return redirect(route('company.dashboard'))->with('error', 'Invalid parameter value');
        }
        $project = Project::find(intval($id));
        if(!Gate::allows('show_project', $project)) redirect(route('company.dashboard'))->with('error', 'you are not authorized');
        Session::flash('download','private/'.$project->krooky_file);
        Session::flash('downloadName','plot');
        return redirect()->back();
    }
    public function downloadContract(string $id){
        if (!is_numeric($id) || Project::find(intval($id)) === null) {
            return redirect(route('company.dashboard'))->with('error', 'Invalid parameter value');
        }
        $project = Project::find(intval($id));
        $offer = auth()->user()->company->projects->find($project->id)->offer;
        if(!Gate::allows('show_project', $project)) redirect(route('company.dashboard'))->with('error', 'you are not authorized');
        Session::flash('download','private/'.$offer->contract_file);
        Session::flash('downloadName','contract_file');
        return redirect()->back();
    }

    public function sendOfferShow(){
        return view("company.send-offer");
    }
    public function sendOffer(Request $request, string $id){
        if (!is_numeric($id) || Project::find(intval($id)) === null) {
            return redirect()->back()->with('error', 'Invalid parameter value');
        }
        if(auth()->user()->company->projects->find(intval($id))->offer->contract_file !== null)
                                return redirect(route('company.dashboard '))->with('error', 'You have already sent an offer');
        $request->validate([
            'contract_file' => [ 'required','file',File::types(['pdf', 'png', 'jpeg', 'jpg','doc','docx'])->max(4 * 1024)],
            'offer_value' => 'required | integer'
        ]);
        if(!Gate::allows('show_project', Project::find(intval($id)))) redirect()->back()->with('error', 'you are not authorized');
        $is_accurate = ( $request->has('is_accurate') ) ? true : false;
        auth()->user()->company->projects()->updateExistingPivot(intval($id), ['value' => $request->input('offer_value')]);
        auth()->user()->company->projects()->updateExistingPivot(intval($id), ['is_accurate' => $is_accurate]);
        auth()->user()->company->projects()->updateExistingPivot(intval($id), ['contract_file' => $request->file('contract_file')->store('contract_files','private')]);
        return redirect(route('company.dashboard'))->with('success','offer sent successfuly');
    }
}
