<div style="padding:0 16px 0 16px">
  <div class="box box-info box-solid collapsed-box">
    <div class="box-header with-border ">
      <h3 class="box-title">Instructions</h3>
  
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse">
            <i class="fa fa-plus"></i>
        </button>
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body" style="">
        <p>Follow the steps to continue to payment.</p>
    </div>
    <!-- /.box-body -->
  </div>
</div>

<form id="js-checkout-form">
  {{ csrf_field() }}
<div class="col-md-6">
  <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title col-lg-12">Online Enrollment Form</h3>
        </div>        
          <div class="box-body">
            <div class="form-group col-lg-12">
                <label for="exampleInputEmail1">You are incoming Grade-level <i style="color:red">{{$ClassDetail->grade_level+1}}</i></label>
                    <br><br>
                <label for="exampleInputEmail1">Available Tuition Fee and Misc Fee</label>
                
                  @if($Tuition)
                    <input type="hidden" value="0" class="checkTution">
                    <input type="hidden" class="form-control" value="{{$PaymentCategory->id}}" name="tution_category">
                    <input type="hidden" id="total_tuition" name="total_tuition" value="{{$Tuition ? $PaymentCategory->tuition->tuition_amt + $PaymentCategory->misc_fee->misc_amt : ''}}">
                    <input type="hidden" id="total_misc" name="total_misc" value="{{$PaymentCategory->misc_fee->misc_amt}}">
                    <input type="hidden" class="form-control" name="description_name" value="SJAI {{$ClassDetail->grade_level+1}} Tuition Fee ({{number_format($PaymentCategory->tuition->tuition_amt, 2) }}) | Miscellenous Fee ({{number_format($PaymentCategory->misc_fee->misc_amt,2)}})" name="tution_category">
                    <p>Tuition Fee ({{number_format($PaymentCategory->tuition->tuition_amt, 2) }}) | Miscellenous Fee ({{number_format($PaymentCategory->misc_fee->misc_amt,2)}})</p>
                  @else
                    <input type="hidden" value="1" class="checkTution">
                    <p>There is no Tution and Miscellenous Fee</p>
                  @endif
                
            </div>    
            <div class="form-group col-lg-12">
              <label for="exampleInputEmail1">Downpayment Fee</label>
              @if($Downpayment)
                <input type="hidden" value="{{$Downpayment->id}}" name="e_downpayment">
                <input type="hidden" id="downpayment" value="{{$Downpayment->downpayment_amt}}" name="e_downpayment">
                <p>{{number_format($Downpayment->downpayment_amt,2)}}</p>             
              @else
                <p>There is no Downpayment yet</p>
              @endif
            </div>    

            <div class="form-group col-lg-12 input-payment">
                <label for="pay_fee">Enter your payment fee</label>
                <input type="number" class="form-control" id="pay_fee" name="pay_fee" placeholder=" {{number_format($Downpayment->downpayment_amt,2)}}">
                <div class="help-block text-left" id="js-pay_fee"></div>
            </div>
           
            <div class="form-group col-lg-12 input-phone">
                <label for="phone">Phone number</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="+639000000000" value="+639{{ $StudentInformation->contact_number }}">
                <div class="help-block text-left" id="js-number"></div>
            </div>  
            <div class="form-group col-lg-12 input-email">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" value="{{ $StudentInformation->email }}">
                <div class="help-block text-left" id="js-email"></div>
            </div>             
            <div class="checkbox col-lg-12">
              <label>
                <input type="checkbox" id="terms">I have read and Agree the <a href="">Terms of service</a>
              </label>
            </div>
          </div>
        </div>
</div>
<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title col-lg-12">Transaction Summary</h3>
        </div>
        <div class="box-body">                  
            <table class="table  table-invoice table-striped">
              <tbody>
                  <tr>                       
                      <tr>
                          <td style="width:140px">Tuition Fee</td>
                          <td align="right" id="tuition_fee"> 
                            @if($Tuition)                             
                              {{number_format($PaymentCategory->tuition->tuition_amt, 2)}}
                            @else
                              <p>There is no Tution Fee yet</p>
                            @endif
                          </td>
                      </tr>
                      <tr>
                          <td style="width:140px">Misc Fee</td>
                          <td align="right" id="misc_fee">
                            @if($Tuition)
                              {{number_format($PaymentCategory->misc_fee->misc_amt,2)}}
                            @else
                              <p>There is no Miscellenous Fee yet</p>
                            @endif
                          </td>
                      </tr>
                      <tr>
                        <td style="width:140px">Total Fees</td>
                        <td align="right" id="misc_fee">
                          @if($Tuition)
                            {{number_format($PaymentCategory->misc_fee->misc_amt + $PaymentCategory->tuition->tuition_amt, 2)}}
                          @else
                            <p>There is no Tution and Miscellenous fee yet</p>
                          @endif
                        </td>
                    </tr>
                      <tr>
                          <td style="width:140px">Payment</td>
                          <td align="right">
                              ₱ <span id="dp_enrollment">0</span>
                          </td>
                      </tr>
                      <tr>
                          <td style="width:140px">Current Balance</td>
                          <td align="right">
                            <input type="hidden" id="result_current_bal" name="result_current_bal">
                              ₱ <span id="current_balance">0</span>
                          </td>
                      </tr>
                      
                  </tr>
              </tbody>
             

            </table>
            
            <div class="box-footer col-lg-12">              
              <button type="button" class="btn-reset btn btn-danger pull-left">Reset</button>
              <button type="submit" disabled id="btn-enroll" class="btn btn-primary pull-right">
                <i class="fab fa-cc-visa"></i> <i class="fab fa-cc-mastercard"></i> Enroll 
              </button>
            </div>
            {{-- @include('control_panel_student.enrollment.partials.modal_paypal') --}}
          
          <div>
            
          </div>
          <img class="img-responsive pull-right" width="210" src="https://logodix.com/logo/244356.png" alt=" img-full">
        </div>
        
      </div>
</div>
</form>