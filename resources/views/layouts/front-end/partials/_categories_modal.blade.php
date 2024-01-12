<!-- Modal -->
<div class="modal fade" id="allCategoriesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered cat-modal" role="document" style="">
    <div class="modal-content">
      <div class="modal-header">
        <h4>{{\App\CPU\translate('category')}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 18px!important;height: 500px;overflow: auto;">
            <div class="row">
                  @foreach(\App\CPU\CategoryManager::parents() as $category)
                <div class="col-lg-2 col-md-2 col-6">
              
                    <div class="card-header mb-2 side-category-bar categori-modal" onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'" style="cursor: pointer;">
                        <span class="cat-span">
                        <img src="{{asset("storage/category/$category->icon")}}" onerror="this.src='{{asset('/assets/front-end/img/image-place-holder.png')}}'">
                           <p>{{$category['name']}}</p> 
                      </span>
                  </div>
            </div>
             @endforeach
            </div>
      </div>
     
    </div>
  </div>
</div>