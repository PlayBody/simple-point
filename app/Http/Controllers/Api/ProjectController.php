<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Role;
use App\Models\Project;
use App\Models\ProjectDetail;
use App\Models\RequestData;
use App\Models\DeliverableData;
use App\Models\Work;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ProjectController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * Response all data
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $user = auth('api')->user();

        $projects = Project::all();
        foreach ($projects as $project) {
            $project->client;
            $project->business;
            // $project->detail;
            // $project->requestData;
            // $project->deliverableData;
        }

        return response()->json([
            'message' => 'success',
            'projects' => $projects,
            'user' => $user
        ], 200);
    }

    /**
     * Response one data by id
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getById(Request $request, $projectId)
    {
        $project = Project::find($projectId);
        $project->client;
        $project->business;
        $project->detail;
        $project->requestData;
        $project->deliverableData;

        return response()->json([
            'message' => 'success',
            'project' => $project,
        ], 200);
    }

    public function getWorkFormats(Request $request) {
        $works = Work::all();
        foreach ($works as $work) {
            $work->outputFormats;
        }

        return response()->json([
            'message' => 'success',
            'work_output_formats' => $works,
        ], 200);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'title' => 'required|string',
            'delivery_date' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $project = new Project;
        $project->admin_id = 1;
        $project->client_id = $request->client_id;
        $project->title = $request->title;
        $project->amount = $request->amount;
        $project->delivery_date = $request->delivery_date;
        $project->status = '作業前';
        $project->save();

        $project->detail()->create([
            'ground_data' => $request->ground_data,
            'ground_data_output' => $request->ground_data_output,
            'simplified_drawing' => $request->simplified_drawing,
            'simplified_drawing_output' => $request->simplified_drawing_output,
            'simplified_drawing_rank' => $request->simplified_drawing_rank,
            'simplified_drawing_scale' => $request->simplified_drawing_scale,
            'contour_data' => $request->contour_data,
            'contour_data_output' => $request->contour_data_output,
            'longitudinal_data' => $request->longitudinal_data,
            'longitudinal_data_output' => $request->longitudinal_data_output,
            'simple_orthphoto' => $request->simple_orthphoto,
            'simple_orthphoto_output' => $request->simple_orthphoto_output,
            'mesh_soil_volume' => $request->mesh_soil_volume,
            'mesh_soil_volume_output' => $request->mesh_soil_volume_output,
            'simple_accuracy_table' => $request->simple_accuracy_table,
            'simple_accuracy_table_output' => $request->simple_accuracy_table_output,
            'public_accuracy_table' => $request->public_accuracy_table,
            'public_accuracy_table_output' => $request->public_accuracy_table_output,
        ]);

        return response()->json([
            'message' => 'success',
            'project' => $project
        ], 200);
    }
    
    public function update(Request $request)
    {
        
    }

    public function addDeliverableData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'deliverable_data_link' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $deliverable_data = new DeliverableData;
        $deliverable_data->project_id = $request->project_id;
        $deliverable_data->deliverable_data_link = $request->deliverable_data_link;
        $deliverable_data->save();

        return response()->json([
            'message' => 'success',
            'deliverable_data' => $deliverable_data
        ], 200);
    }

    public function addRequestData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'request_data_link' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $request_data = new RequestData;
        $request_data->project_id = $request->project_id;
        $request_data->request_data_link = $request->request_data_link;
        $request_data->save();

        return response()->json([
            'message' => 'success',
            'request_data' => $request_data
        ], 200);
    }

    public function deleteDeliverableData($dataId)
    {
        //delete DeliverableData
        $deliverable_data = DeliverableData::find($dataId);
        $projectId = $deliverable_data->project_id;
        $deliverable_data -> delete();

        $project = Project::find($projectId);
        $project->client;
        $project->business;
        $project->detail;
        $project->requestData;
        $project->deliverableData;

        return response()->json([
            'message' => 'success',
            'project' => $project,
        ], 200);
    }

    public function deleteRequestData($dataId)
    {
        //delete RequestData
        $request_data = RequestData::find($dataId);
        $projectId = $request_data->project_id;
        $request_data -> delete();

        $project = Project::find($projectId);
        $project->client;
        $project->business;
        $project->detail;
        $project->requestData;
        $project->deliverableData;

        return response()->json([
            'message' => 'success',
            'project' => $project,
        ], 200);
    }

    public function assignProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'business_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $project = Project::find($request->project_id);
        $project->business_id = $request->business_id;
        $project->save();

        return response()->json([
            'message' => 'success',
            'project' => $project
        ], 200);
    }

    public function setStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $project = Project::find($request->project_id);
        $project->status = $request->status;
        $project->save();

        return response()->json([
            'message' => 'success',
            'project' => $project
        ], 200);
    }

    public function delete($projectId)
    {
        //delete Project
        $project = Project::find($projectId);
        $project -> delete();

        $projects = Project::all();
        foreach ($projects as $project) {
            $project->client;
            $project->business;
            // $project->detail;
            // $project->requestData;
            // $project->deliverableData;
        }

        return response()->json([
            'message' => 'success',
            'projects' => $projects
        ], 200);
    }
}
