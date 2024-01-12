
<style>
    .gallary-card{
        border: 1px solid #e7eaf3;
        padding: 14px;
        }
    .gallary-card img{
        margin-top: 10px;
    }  
        
      .dropdown-file {
        position: absolute;
        top: 0px;
        right: 4px;
        z-index: 1;
    }
    
    .dropdown-file > a {
        color: #5a5a5a;
        font-size: 12px;
        background: #f5f6fa;
        cursor: pointer;
        padding: 1px 4px;
    }
    
    .dropdown-item {
        display: block;
        width: 100%;
        padding: 0.5rem 1.5rem;
        clear: both;
        font-weight: 400;
        color: #74788d;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
      .dropdown-menu-right{
        top: -10px!important;
        border-radius: 0px!important;
      } 
      
      /*.modal-dialog {
        position: fixed;
        margin: auto;
        width: 320px;
        height: 100%;
        right: 0px;
    }*/
    
    
    .modal.fade .modal-dialog-right {
       /* position: absolute;*/
        right: 0;
        top: 0;
        bottom: 0;
        height: 100%;
        margin-right: 47px;
        width: 420px;
        max-width: 80vw;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-flow: column nowrap;
        flex-flow: column nowrap;
        background-color: #fff;
        -ms-flex-line-pack: center;
        align-content: center;
        -webkit-transform: translate(50px, 0);
        transform: translate(50px, 0);
    }
    
    
    
    </style>
    
    <div class="modal fade" id="exampleModalScrollable1" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
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
                    <div class="form-group">
                        <label>File Name</label>
                        <input type="text" class="form-control" value="uploads/all/vrQrFYX5Y59YqEQAFiEFIgcwB6vZkI98Qcw4gwWo.png" disabled="">
                    </div>
                    <div class="form-group">
                        <label>File Type</label>
                        <input type="text" class="form-control" value="image" disabled="">
                    </div>
                    <div class="form-group">
                        <label>File Size</label>
                        <input type="text" class="form-control" value="112.56 KB" disabled="">
                    </div>
                    <div class="form-group">
                        <label>Image Title</label>
                        <input type="text" class="form-control" value="" >
                    </div>
                    <div class="form-group">
                        <label>Image Alt Tag</label>
                        <input type="text" class="form-control" value="" >
                    </div>
                    <div class="form-group">
                        <label>Meta Title</label>
                        <input type="text" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <input type="text" class="form-control" value="" >
                    </div>
                    <div class="form-group text-center">
                        <a class="btn btn-secondary" href="" target=""> Update</a>
                    </div>
                </div>
            </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Schliessen</button>         
            </div>-->
          </div>
        </div>
      </div>
      
    <div class="footer">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-4 mb-3 mb-lg-0">
                <p class="font-size-sm mb-0 title-color text-center text-lg-left">
                    &copy; {{\App\Model\BusinessSetting::where(['type'=>'company_name'])->first()->value}}. <span
                        class="d-none d-sm-inline-block">{{\App\Model\BusinessSetting::where(['type'=>'company_copyright_text'])->first()->value}}</span>
                </p>
            </div>
            <div class="col-lg-8">
                <div class="d-flex justify-content-center justify-content-lg-end">
                    <!-- List Dot -->
                    <ul class="list-inline list-footer-icon justify-content-center justify-content-lg-start mb-0">
                        <li class="list-inline-item">
                            <a class="list-separator-link" href="{{route('admin.business-settings.web-config.index')}}">
                                <i class="tio-settings"></i>
                                {{\App\CPU\translate('Business Setup')}}
                            </a>
                        </li>
    
                        <li class="list-inline-item">
                            <a class="list-separator-link"href="{{route('admin.profile.update',auth('admin')->user()->id)}}">
                                <i class="tio-user"></i>
                                {{\App\CPU\translate('Profile')}}
                            </a>
                        </li>
    
                        <li class="list-inline-item">
                            <a class="list-separator-link" href="{{route('admin.dashboard.index')}}">
                                <i class="tio-home-outlined"></i>
                                {{\App\CPU\translate('Home')}}
                            </a>
                        </li>
    
                        <li class="list-inline-item" style="display: none;">
                            <label class="badge badge-soft-version text-capitalize">
                                {{\App\CPU\translate('Software version')}} {{ env('SOFTWARE_VERSION') }}
                            </label>
                        </li>
                    </ul>
                    <!-- End List Dot -->
                </div>
            </div>
        </div>
    </div>
    