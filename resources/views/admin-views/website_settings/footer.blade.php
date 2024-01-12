@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Footer'))

@section('content')

	<div class="content container-fluid">
		<!-- Page Title -->
		<div class="mb-3">
			<h2 class="h1 mb-1 text-capitalize d-flex align-items-center gap-2">
				<img width="20" src="{{asset('/public/assets/back-end/img/banner.png')}}" alt="">
				{{\App\CPU\translate('Website Footer')}}
			</h2>
		</div>
		<!-- End Page Title -->
	
		<div class="row " >
			<div class="col-md-12">
				<div class="card">
					<div class="px-3 py-4">
						<div class="row align-items-center">
							<div class="col-md-4 col-lg-6 mb-2 mb-md-0">
								<h5 class="mb-0 text-capitalize d-flex gap-2">
									{{ \App\CPU\translate('Link Widget One')}}
									<span
										class="badge badge-soft-dark radius-50 fz-12"></span>
								</h5>
							</div>
							<div class="col-md-8 col-lg-6">
								<div
									class="d-flex align-items-center justify-content-md-end flex-wrap flex-sm-nowrap gap-2">
	
								</div>
							</div>
						</div>
					</div>
					
					<div class="card-body">
						<div class="row gutters-10">
					
							<div class="col-lg-12">
								
								
									<div class="card-body">
										<form action="{{ route('admin.website.footer.one') }}" method="POST" enctype="multipart/form-data">
											@csrf											
											<div class="form-group">
												<label>{{ 'Links Translatable Label' }}</label>
												<div class="w3-links-target">																									
													
												@foreach ($data1 as $key=>$wid1)	
													<input type="hidden" name="count" value="{{ $data1->count() }}">
													<input type="hidden" name="widget_col" value="1">											 														
																							   
															<div class="row gutters-5">
																<div class="col-4">
																	<div class="form-group">
																		<input type="text" class="form-control" placeholder="{{'Label'}}" name="type[]" value="{{ $wid1->type }}" required>
																		<input type="hidden" name="wid1id[]" value="{{ $wid1->id }}">
																	</div>
																</div>
																<div class="col">
																	<div class="form-group">
																		<input type="url" class="form-control" placeholder="http://" name="value[]" value="{{ $wid1->value }}" required>
																	</div>
																</div>
																<div class="col-auto">
																<a href="{{ route('admin.website.footer.one.destroy',[$wid1->id]) }}"  class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger"><i class="tio-delete"></i></a>
																</div>
															</div>
													@endforeach
												
												</div>
												
				
										      </div>
											  <div class="text-right">
												<button type="submit" class="btn btn-primary">{{ 'Update' }}</button>
											</div>
									</form>
										</div>
												
										<p>
									
										<a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
											{{ 'Add New' }}
										</a>
										
									  </p>
									  <div class="collapse" id="collapseExample">
										<div class="card-body">
											<form action="{{ route('admin.website.footer.one.store') }}" method="POST" >
												@csrf
											<input type="hidden" name="widget_col" value="1">
											<div class="row gutters-5">
												<div class="col-4">
													<div class="form-group">
														<input type="text" class="form-control" placeholder="{{'Label'}}" name="type" value="" required>
													</div>
												</div>
												<div class="col">
													<div class="form-group">
														<input type="url" class="form-control" placeholder="http://" name="value" value="" required>
													</div>
												</div>
												<div class="col-auto">
													<button type="submit" class="btn btn-primary" data-toggle="remove-parent" data-parent=".row">
															
														<i class="tio-add"></i>Add
													</button>
												</div>
											</div>
											</form>
											</div>
									  </div>
									</div>	
								
							</div>
						</div>
				</div>
					
			</div>				
	
			<div class="col-md-12 mt-5">
				<div class="card">
					<div class="px-3 py-4">
						<div class="row align-items-center">
							<div class="col-md-4 col-lg-6 mb-2 mb-md-0">
								<h5 class="mb-0 text-capitalize d-flex gap-2">
									{{ \App\CPU\translate('Link Widget Two')}}
									<span
										class="badge badge-soft-dark radius-50 fz-12"></span>
								</h5>
							</div>
							<div class="col-md-8 col-lg-6">
								<div
									class="d-flex align-items-center justify-content-md-end flex-wrap flex-sm-nowrap gap-2">
	
								</div>
							</div>
						</div>
					</div>
					
					<div class="card-body">
						<div class="row gutters-10">
					
							<div class="col-lg-12">
								
								
									<div class="card-body">
										<form action="{{ route('admin.website.footer.two') }}" method="POST" enctype="multipart/form-data">
											@csrf											
											<div class="form-group">
												<label>{{ 'Links Translatable Label' }}</label>
												<div class="w3-links-target">																									
													
												@foreach ($data2 as $key=>$wid2)	
															
													<input type="hidden" name="count" value="{{ $data2->count() }}">
													
													<input type="hidden" name="widget_col" value="2">											 														
																							   
															<div class="row gutters-5">
																<div class="col-4">
																	<div class="form-group">
																		<input type="text" class="form-control" placeholder="{{'Label'}}" name="type[]" value="{{ $wid2->type }}" required>
																		<input type="hidden" name="wid2id[]" value="{{ $wid2->id }}">
																	</div>
																</div>
																<div class="col">
																	<div class="form-group">
																		<input type="url" class="form-control" placeholder="http://" name="value[]" value="{{ $wid2->value }}" required> 
																	</div>
																</div>
																<div class="col-auto">
																<a href="{{ route('admin.website.footer.two.destroy',[$wid2->id]) }}"  class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger"><i class="tio-delete"></i></a>
																</div>
															</div>
													@endforeach
												
												</div>
												
				
										      </div>
											  <div class="text-right">
												<button type="submit" class="btn btn-primary">{{ 'Update' }}</button>
											</div>
									</form>
										</div>
												
										<p>
									
										<a class="btn btn-primary" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
											{{ 'Add New' }}
										</a>
										
									  </p>
									  <div class="collapse" id="collapseExample2">
										<div class="card-body">
											<form action="{{ route('admin.website.footer.two.store') }}" method="POST" >
												@csrf
											<input type="hidden" name="widget_col" value="2">
											<div class="row gutters-5">
												<div class="col-4">
													<div class="form-group">
														<input type="text" class="form-control" placeholder="{{'Label'}}" name="type" value="" required>
													</div>
												</div>
												<div class="col">
													<div class="form-group">
														<input type="url" class="form-control" placeholder="http://" name="value" value="" required>
													</div>
												</div>
												<div class="col-auto">
													<button type="submit" class="btn btn-primary" data-toggle="remove-parent" data-parent=".row">
															
														<i class="tio-add"></i>Add
													</button>
												</div>
											</div>
											</form>
											</div>
									  </div>
									</div>	
								
							</div>
						</div>
				</div>
					
			</div>				
			
				
		</div>
	
	</div>
	
 
@endsection
