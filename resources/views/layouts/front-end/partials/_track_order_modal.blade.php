<!-- Track order Modal -->
<div class="modal fade" id="trackOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered track-modal" role="document">
      <div class="modal-content">
         <button type="button" class="close j-modal-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
       
        <div class="modal-body">
           <div class="modal-body">
              <div class="auth-content-wrapper">
                  <div class="track-intro">
                      <div class="track-intro-img">
                          <img src="{{asset('/assets/front-end/img/track.png')}}">
                      </div>
                      
                  </div>
                  <div class="auth-form sign-in">
                      <div class="box-shadow-sm order-track">
                          <div style="margin: 0 auto; padding: 15px;">
                              <h2 style="padding: 20px; text-align: center;font-size: 25px;">Track Your Order</h2>
  
                              <form action="{{route('track-order.result')}}" type="submit" method="post"
                                    style="padding: 15px;">
                                  @csrf
  
                                  @if(session()->has('Error'))
                                      <div class="alert alert-danger alert-block">
                                          <span type="" class="closet " data-dismiss="alert">×</span>
                                          <strong>{{ session()->get('Error') }}</strong>
                                      </div>
                                  @endif
  
                                  <div class="form-group track-group track-group1">
                                      <img src="{{asset('/assets/front-end/img/box.svg')}}">
                                      <input class="form-control prepended-form-control border-none border-none1" type="text" name="order_id"
                                             placeholder="Enter your order ID" required>
                                  </div>
                                  <div class="form-group track-group">
                                      <img src="{{asset('/assets/front-end/img/mobile.png')}}">
                                      <input class="form-control prepended-form-control border-none" type="text" name="phone_number" onkeypress="return validateNumber(event)"
                                             placeholder="Phone number" required>
                                  </div>
                                  <div class="input-group-append">
                                      <button class="btn track-btn" type="submit" name="trackOrder">{{\App\CPU\translate('track_order')}}</button>
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
    
    <!---->
    
    
    <!---->
  </div>