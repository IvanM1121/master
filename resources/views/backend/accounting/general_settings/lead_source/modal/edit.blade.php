<form method="post" class="ajax-screen-submit" autocomplete="off" action="{{ action('LeadSourceController@update', $id) }}" enctype="multipart/form-data">
	{{ csrf_field()}}
	<input name="_method" type="hidden" value="PATCH">				
	
	<div class="col-md-12">
		<div class="form-group">
		   <label class="control-label">{{ _lang('Title') }}</label>						
			<input type="text" class="form-control" name="title" value="{{ $leadsource->title }}" required>
			<label class="control-label">{{ _lang('Name') }}</label>
			<input type="text" class="form-control" name="name" value="{{ $leadsource->name }}" required>
			<label class="control-label">{{ _lang('Description') }}</label>
			<input type="text" class="form-control" name="description" value="{{ $leadsource->description }}" required>
			<div class="form-group">
				<label class="control-label">{{ _lang('Users') }}</label>						
				<select class="form-control select2" name="users[]" multiple="true">
					{{ create_option('users','id','name','',array('company_id=' => company_id())) }}
				</select>
			</div>
		</div>
	</div>
	
	<div class="form-group">
	    <div class="col-md-12">
		    <button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
	    </div>
	</div>
</form>

