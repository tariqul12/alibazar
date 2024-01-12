@extends('layouts.back-end.app')
@section('title',\App\CPU\translate('gallery'))
@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/file-manager.png')}}" width="20" alt="">
                {{\App\CPU\translate('file_manager')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Page Heading -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">{{\App\CPU\translate('file_manager')}}</h5>
            <button type="button" class="btn btn--primary modalTrigger" data-toggle="modal" data-target="#exampleModal">
                <i class="tio-add"></i>
                <span class="text">{{\App\CPU\translate('add')}} {{\App\CPU\translate('new')}}</span>
            </button>
        </div>


<!--<button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModalScrollable" id="btn1">mehr Erfahren</button>-->

<!-- Modal -->

  
 


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @php
                            $pwd = explode('/',base64_decode($folder_path));
                        @endphp
                        <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                            {{end($pwd)}}
                            <span class="badge badge-soft-dark radius-50" id="itemCount">{{count($data)}}</span>
                        </h5>
                        <a class="btn btn--primary" href="{{url()->previous()}}">
                            <i class="tio-chevron-left"></i>
                            {{\App\CPU\translate('back')}}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($data as $key=>$file)
                                <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                    
                                    @if($file['type']=='folder')
                                        <a class="btn p-0"
                                           href="{{route('admin.file-manager.index', base64_encode($file['path']))}}">
                                            <img class="img-thumbnail mb-2"
                                                 src="{{asset('public/assets/back-end/img/folder.png')}}" alt="">
                                            <p class="title-color">{{Str::limit($file['name'],10)}}</p>
                                        </a>
                                    @elseif($file['type']=='file')
                                    <!-- <a class="btn" href="{{asset('storage/app/'.$file['path'])}}" download> -->
                                        <button class="btn p-0 w-100" data-toggle="modal"
                                                data-target="#imagemodal{{$key}}" title="{{$file['name']}}">
                                            <div class="gallary-card">
                                                
                                                
                                                <!-------------------------------->
                                                <div class="dropdown-file">
                    								<a class="dropdown-link" data-toggle="dropdown">
                    								    <i class="tio-chevron-down"></i>
                    								</a>
                    								<div class="dropdown-menu dropdown-menu-right">
                    									<a class="dropdown-item"  id="btn1" onclick="file_details('{{$file['name']}}','{{$key}}')">
                    										<i class="tio-edit"></i>
                    										<span>Details Info</span>
                    									</a>
                    									<a href="" class="dropdown-item">
                    										<i class="tio-download-to"></i>
                    										<span>Download</span>
                    									</a>
                    									<a href="" class="dropdown-item" >
                    										
                    										<i class="tio-copy"></i>
                    										<span>Copy Link</span>
                    									</a>
                    									<a href="" class="dropdown-item confirm-alert">
                    										<i class="tio-delete"></i>
                    										<span>Delete</span>
                    									</a>
                    								</div>
                    							</div>
                    							
                                                <!--------------------->
                                                <img src="{{asset('storage/app/'.$file['path'])}}"
                                                     alt="{{$file['name']}}" class="h-auto w-100 mb-2">
                                            </div>
                                            <p class="overflow-hidden">{{Str::limit($file['name'],10)}}</p>
                                        </button>
                                        <!--<div class="modal fade" id="imagemodal{{$key}}" tabindex="-1" role="dialog"
                                             aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">{{$file['name']}}</h4>
                                                        <button type="button" class="close" data-dismiss="modal"><span
                                                                aria-hidden="true">&times;</span><span
                                                                class="sr-only">{{\App\CPU\translate('close')}}</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="{{asset('storage/app/'.$file['path'])}}"
                                                             class="w-100 h-auto">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a class="btn btn--primary"
                                                           href="{{route('admin.file-manager.download', base64_encode($file['path']))}}"><i
                                                                class="tio-download"></i> {{\App\CPU\translate('download')}}
                                                        </a>
                                                        <button class="btn btn-info"
                                                                onclick="copy_test('{{$file['db_path']}}')"><i
                                                                class="tio-copy"></i> {{\App\CPU\translate('copy_path')}}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                                    @endif
                                </div>
                                {{-- modal details info --}}
                                    <div class="modal fade" id="detailsInfo{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-right" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalScrollableTitle">File Info</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            
                                            <div class="modal-body">
                                            <div>
                                                <form action="{{route('admin.file-manager.file_details_update')}}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>File Name</label>
                                                        <input type="text" class="form-control" name="file_name" value="" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Image Title</label>
                                                        <input type="text" class="form-control" name="img_title" value="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Image Alt Tag</label>
                                                        <input type="text" class="form-control" name="img_alt_tag" value="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Meta Title</label>
                                                        <input type="text" class="form-control" name="meta_title" value="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Meta Description</label>
                                                        <input type="text" class="form-control" name="meta_discription" value="" required>
                                                    </div>
                                                    <div class="form-group text-center">
                                                        <button type="submit" class="btn btn-secondary">Update</button>
                                                    </div>
                                                </form>
                                                   
                                                </div>
                                            </div>
                                            <!--<div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schliessen</button>         
                                            </div>-->
                                        </div>
                                        </div>
                                    </div>
                                    {{-- end --}}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <!--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="indicator"></div>
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="exampleModalLabel">{{\App\CPU\translate('upload')}} {{\App\CPU\translate('File')}} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.file-manager.image-upload')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="path" value="{{base64_decode($folder_path)}}" hidden>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" name="images[]" id="customFileUpload" class="custom-file-input"
                                           accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" multiple>
                                    <label class="custom-file-label"
                                           for="customFileUpload">{{\App\CPU\translate('choose')}} {{\App\CPU\translate('images')}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" name="file" id="customZipFileUpload" class="custom-file-input"
                                           accept=".zip">
                                    <label class="custom-file-label" id="zipFileLabel"
                                           for="customZipFileUpload">{{\App\CPU\translate('upload_zip_file')}}</label>
                                </div>
                            </div>

                            <div class="row" id="files"></div>
                            <div class="form-group">
                                <input class="btn btn--primary" type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                       onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                       value="{{\App\CPU\translate('upload')}}">
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>-->
    </div>
@endsection

@push('script_2')
    <script>
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        function file_details(file_name,key)
        {
            var _token = "{{ csrf_token() }}";   
            $.ajax({
            type: 'POST',
            url: "{{ route('admin.file-manager.file_details') }}",
            data: {
                file_name: file_name,
                _token: _token
            },
            success: function(data) {
                console.log(data['file_name']);
                if (data) {
                    $('input[name="file_name"]').val(data['file_name']);
                    $('input[name="img_title"]').val(data['img_title']);
                    $('input[name="img_alt_tag"]').val(data['img_alt_tag']);
                    $('input[name="meta_title"]').val(data['meta_title']);
                    $('input[name="meta_discription"]').val(data['meta_description']);
                    $('#detailsInfo'+key).modal('show');
                    
                }

            }
        });
        }
        function readURL(input) {
            $('#files').html("");
            for (var i = 0; i < input.files.length; i++) {
                if (input.files && input.files[i]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#files').append('<div class="col-md-2 col-sm-4 m-1"><img style="width: 100%;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewer" src="' + e.target.result + '"/></div>');
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }

        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });

        $('#customZipFileUpload').change(function (e) {
            var fileName = e.target.files[0].name;
            $('#zipFileLabel').html(fileName);
        });

        function copy_test(copyText) {
            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText);

            toastr.success('{{\App\CPU\translate('file_path_copied_successfully!')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endpush
