<div class="modal-dialog modal-lg" role="document">
    <?php $services = getServices();
     $locale = Illuminate\Support\Facades\App::getLocale();
     $name = "service_name_".$locale;  ?>

    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1"> {{ __('labels.Send System Notifications') }}</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('SystemNotification.store') }}" id="service-frm">
                @csrf
                <div class="row g-2">

           
                    <div class="col-md-6">
                        <label class="form-label" for="validationServer01">{{ __('labels.User Type') }}</label>
                            <select class="form-select usertype" name="usertype" id="validationDefault04">
                            <option selected="" value="">{{ __('labels.Select User Type') }}</option>
                              
                                <option value="3">{{ __('labels.Barber') }}</option>
                                <option value="4">{{ __('labels.Customer') }}</option>
                            </select>
                            <div id="usertype_error" style="display: none;" class="text-danger"></div>
                    </div>
                
                    <div class="col-md-6">
                        <label class="form-label" for="validationServer01">{{ __('labels.Notification Type') }}</label>
                        <select class="form-select notification_type" name="notification_type" id="validationDefault04">
                            <option selected="" value="">{{ __('labels.Select Notification Type') }}</option>
                           
                            <option value="email">{{ __('labels.Email') }}</option>
                            <option value="push">{{ __('labels.Push Notification') }}</option>
                            <option value="both">{{ __('labels.Both') }}</option>
                           
                            
                        </select>
                        <div id="notification_type_error" style="display: none;" class="text-danger"></div>
                    </div>
                    


                    <div class="col-md-6">
                        <label class="form-label" for="title">{{ __('labels.Title') }} <span class="text-danger">*</span> </label>
                        <input class="form-control" id="title" name="title" type="text"
                            placeholder="{{ __('labels.Title') }}" aria-label="{{ __('labels.Title') }}">
                        <div id="title_error" style="display: none;" class="text-danger"></div>
                    </div>

                
                    <div class="col-md-6">
                        <label class="form-label" for="description">{{ __('labels.Description') }} <span class="text-danger">*</span> </label>
                        <textarea class="form-control" id="description" name="description" 
                        placeholder="{{ __('labels.Description') }}" 
                        aria-label="{{ __('labels.Description') }}"></textarea>
              
                        <div id="description_error" style="display: none;" class="text-danger"></div>
                    </div>
               


              


                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="citySubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> {{ __('labels.Submit') }}</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">{{ __('labels.Close') }}</button>
            </form>
        </div>
    </div>
</div>


