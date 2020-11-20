<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeadSource;
use App\lead_source_users;
use Validator;

class LeadSourceController extends Controller
{
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set(get_company_option('timezone', get_option('timezone','Asia/Dhaka'))); 

        $this->middleware(function ($request, $next) {
            if( has_membership_system() == 'enabled' ){
                if( ! has_feature( 'project_management_module' ) ){
                    if( ! $request->ajax()){
                        return redirect('membership/extend')->with('message', _lang('Sorry, This feature is not available in your current subscription. You can upgrade your package !'));
                    }else{
                        return response()->json(['result'=>'error','message'=>_lang('Sorry, This feature is not available in your current subscription !')]);
                    }
                }
            }

            return $next($request);
        });
    }
	

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function index(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.accounting.general_settings.lead_source.newcreate');
        }else{
           return view('backend.accounting.general_settings.lead_source.modal.newcreate');
        }
    }
    public function create(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.accounting.general_settings.lead_source.create');
        }else{
           return view('backend.accounting.general_settings.lead_source.modal.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
			'order' => '',
			'company_id' => '',
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return redirect()->route('lead_sources.create')
                	             ->withErrors($validator)
                	             ->withInput();
            }			
        }
	
        

        $leadsource = new LeadSource();
        $leadsource->title = $request->input('title');
        //20201116 changed by Ivan*
        $leadsource->name = $request->input('name');
        $leadsource->description = $request->input('description');
        //***** */
		//$leadsource->order = $request->input('order');
		$leadsource->company_id = company_id();

        $leadsource->save();

        //20201116 changed by Ivan
        
        if(isset($request->users)){
            foreach($request->users as $user){

                $lead_user  = new lead_source_users();
                $lead_user->leadsource_id = $leadsource->id;
                $lead_user->user_id = $user;
                $lead_user->save();

                // create_log('leadsource', $project->id, _lang('Assign to').' '.$lead_user->user->name);
            }
        }      

        if(! $request->ajax()){
           return back()->with('success', _lang('Saved Sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully'),'data'=>$leadsource, 'table' => '#lead_source_table']);
        }        
   }
	

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $leadsource = LeadSource::where('id',$id)
                                ->where('company_id', company_id())
                                ->first();
        if(! $request->ajax()){
            return view('backend.accounting.general_settings.lead_source.edit',compact('leadsource','id'));
        }else{
            return view('backend.accounting.general_settings.lead_source.modal.edit',compact('leadsource','id'));
        }  
        
    }

    
    public function show(Request $request,$id)//20201117 view newadd
    {
        $leadsource = LeadSource::where('id',$id)
                                ->where('company_id', company_id())
                                ->first();
        $leadsource_users = \App\lead_source_users::with(['user','leadsource'])->get();
        $leads = \App\Lead::where('lead_source_id',$id)->get();
        $purchase_orders = \App\Purchase::with(['supplier','chartofaccount'])->where('lead_source_id',$id)->get();
        
        if(! $request->ajax()){
            return view('backend.accounting.general_settings.lead_source.view',compact('leadsource','id','leadsource_users','leads','purchase_orders'));
        }else{
            return view('backend.accounting.general_settings.lead_source.modal.view',compact('leadsource','id', 'leadsource_users','leads','purchase_orders'));
        }      
    }
   



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$validator = Validator::make($request->all(), [
			'title' => 'required|max:50',
			'order' => '',
			'company_id' => '',
		]);

		if ($validator->fails()) {
			if($request->ajax()){ 
				return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('lead_sources.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $leadsource = LeadSource::where('id',$id)
                                ->where('company_id', company_id())
                                ->first();
        
        $leadsource->title = $request->input('title');
        //20201116 changed by Ivan*
        $leadsource->name = $request->input('name');
        $leadsource->description = $request->input('description');
        //***** */
        //$leadsource->order = $request->input('order');
        $leadsource->company_id = company_id();
	
        $leadsource->save();


        ///
        $existing_members  = lead_source_users::where('leadsource_id',$id)->get();
      

        
        if(isset($request->users)){
            
            //Remove Project Members
            foreach($existing_members as $existing_member){
                if(! in_array($existing_member->user_id, $request->users)){
                    $leadsource_member = lead_source_users::find($existing_member->user_id);
                    //create_log('projects', $project->id, _lang('Remove').' '.$project_member->user->name.' '._lang('from Project'));
                    $leadsource_member->delete();
                }
            }
            die(print_r($id));
            //Store New Project Members
            foreach($request->users as $user){
                if(! $existing_members->contains('user_id', $user)){
                    //Added New Member
                    
                    $lead_user  = new lead_source_users();
                    $lead_user->leadsource_id = $id;
                    $lead_user->user_id = $user;
                    
                    $lead_user->save();

                    //create_log('projects', $project->id, _lang('Assign to').' '.$project_member->user->name);
                }          
            }
        }else{
             $existing_members  = lead_source_users::where('leadsource_id',$id);
             $existing_members->delete();
        }

        
		
		if(! $request->ajax()){
           return back()->with('success', _lang('Updated Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Updated Sucessfully'),'data'=>$leadsource, 'table' => '#lead_source_table']);
		}
	    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $leadsource = LeadSource::where('id',$id)
                                ->where('company_id', company_id());
        $leadsource->delete();
		
        if(! $request->ajax()){
           return back()->with('success', _lang('Deleted Sucessfully'));
        }else{
           return response()->json(['result'=>'success', 'message'=>_lang('Deleted Sucessfully'), 'id'=>$id, 'table' => '#lead_source_table']);
        }
    }
}