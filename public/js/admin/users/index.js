$(document).ready(function(){      
 window.pageData={
   controller:'user',
   currentPage:0,
   confirmMsg:'Are you sure?'
 };

 window.pageMethods={
   filterRecords(){
     $.ajax({
       url:adminPath(window.pageData.controller+'/filter'),
       dataType:'HTML',
       type:'POST',
       data:{
         'first_name':$('[name=filter-first_name]').val(),
         'last_name':$('[name=filter-last_name]').val(),
         'email':$('[name=filter-email]').val(),
         'mobile':$('[name=filter-mobile]').val(),
         'address':$('[name=filter-address]').val(),
         'national_id':$('[name=filter-national_id]').val(),
         'bank_account':$('[name=filter-bank_account]').val(),
         'iban':$('[name=filter-iban]').val(),

         'status':$('[name=filter-status]').val(),
         'user_type':$('[name=filter-user_type]').val(),


         'termLocation':termLocation,
         filterPage:window.pageData.currentPage,
         order_by:window.pageData.order_by,
         order_type:window.pageData.order_type
       },
       success:function(res){
         $('#filter-results').html(res);
       }
     });/*ajax*/
   }
 }/*filterRecords*/

 pageMethods.filterRecords();


 $('body').delegate('#save-record-btn','click',function(e){
   e.preventDefault();
   var route = 
     (current_record)?
       adminPath('update-user/'+current_record) : adminPath(window.pageData.controller);

   var type = 'POST';

   var options={
    url     : route,
    dataType: 'JSON',
    beforeSubmit:function(){
     disableAll();        
    },
    
    type:type,   
     success : function (res,status){
      enableAll();
      window.scrollTo(0,0);
      var alertType = (res.status)? 'ok' : 'error';
      showAlert(alertType,'man-'+window.pageData.controller,res.msg);
      setTimeout(function(){
        $('#edit-record-modal').modal('hide');
      },2000);
      pageMethods.filterRecords();
     }/*End success*/
   }; 

  $('#man-'+window.pageData.controller+'-form').ajaxSubmit(options);
  return false;	

 });


 $('body').delegate('.change-user-status-btn','click',function(e){
  e.preventDefault();
  let that = $(this);
  current_record = parseInt(that.data('id'));
  $.ajax({
    url:adminPath(window.pageData.controller+'/'+current_record+'/status'),
    dataType:'HTML',
    success:function(res){
      $('#edit-record-modal').find('.modal-body').html(res);
      $('#edit-record-modal').modal('show');   
      $('#edit-record-modal').find('.btn-success').attr('id','save-change-user-status-btn');
     }
  });
 });

 $('body').delegate('#save-change-user-status-btn','click',function(e){
  e.preventDefault();    
  $.ajax({
    url:adminPath(window.pageData.controller+'/'+current_record+'/status'),
    type:'POST',
    data:{
      new_status:$('[name=new_status]').val(),
      new_reason:$('[name=new_reason]').val()
    }, 
    success:function(res){
      res.status? alertOK('change-status',res.message) : alertError('change-status',res.message);
      pageMethods.filterRecords();
      $('#edit-record-modal').modal('hide');
     }
  });
 });

 $('body').delegate('.show-update-profile-request-btn','click',function(e){
   e.preventDefault();
   let that = $(this);
   current_record = that.data('id');
   $.ajax({
     url:adminPath(window.pageData.controller+'/'+current_record+'/updateProfileRequest'),
     dataType:'HTML',
     success:function(res){
      $('#general-modal').find('.modal-body').html(res);
      $('#general-modal').modal('show');
     }
   });
 });

 $('body').delegate('#reject-update-profile-request-btn','click',function(e){
  e.preventDefault();
  let that = $(this);
  current_record = that.data('id');
  $.ajax({
    url:adminPath(window.pageData.controller+'/'+current_record+'/updateProfileRequest/reject'),
    type:'POST',
    success:function(res){
      enableAll();
      alertOK('save-user-profile-update-request',res.msg);
      pageMethods.filterRecords();
      $('#general-modal').modal('hide');
    }
  });
 });

 $('body').delegate('#approve-update-profile-request-btn','click',function(e){
  e.preventDefault();
  let that = $(this);
  current_record = that.data('id');
  $.ajax({
    url:adminPath(window.pageData.controller+'/'+current_record+'/updateProfileRequest/approve'),
    type:'POST',
    success:function(res){
      enableAll();
      alertOK('save-user-profile-update-request',res.msg);
      pageMethods.filterRecords();
      $('#general-modal').modal('hide');
    }
  });
 });

 $('body').delegate('[name=country_code]','change',function(e){   
  $('#country_code_span').text($(this).find(':selected').data('phone-code'));
});/**/

 $('body').delegate('[name=country_id]','change',function(e){
   e.preventDefault();
   let selected_country = $(this).val();
   $.ajax({
     url:apiPath('general-get-areas/'+selected_country),
     dataType:'JSON',
     headers: {
      'Accept-Language':'en'
      },
     success:function(res){
       let areas = res.data;
       $('[name=city_id]').html('');
       $('[name=area_id]').html('');

       let first_area = areas[0];
       
       for(let i=0;i<areas.length;i++){
        let area = areas[i];
        $('[name=area_id]').append($('<option></option>').val(area.id).html(area.title));
       }
       
       for(let i=0;i<first_area.cities.length;i++){
        let city = first_area.cities[i];
        $('[name=city_id]').append($('<option></option>').val(city.id).html(city.title));
       }

     }
   });/*Ajax*/
 });/*on changing country_id*/


 $('body').delegate('[name=area_id]','change',function(e){
  e.preventDefault();
   let selected_area = $(this).val();
   $.ajax({
     url:apiPath('general-get-area-cities/'+selected_city),
     dataType:'JSON',
     headers: {
      'Accept-Language':'en'
      },
     success:function(res){
       let cities = res.data;
       $('[name=city_id]').html('');       
       
       for(let i=0;i<cities.length;i++){
        let city = cities[i];
        $('[name=city_id]').append($('<option></option>').val(city.id).html(city.title));
       }
       

     }
   });/*Ajax*/
 });/*on changing city_id*/



 
$('body').delegate('.show-eye-btn','click',function(e){
  e.preventDefault();
  let icon = $(this).find('i.fas');
  let span = $(this);
  if(icon.hasClass('fa-eye')){
    icon.removeClass('fa-eye').addClass('fa-eye-slash');
    $('[name='+span.data('related-element')+']').attr('type','text');
  }else{
    icon.removeClass('fa-eye-slash').addClass('fa-eye');
    $('[name='+span.data('related-element')+']').attr('type','password');
  }   
});/*del*/

$('body').delegate('[name=car_type_id]','change',function(e){
  let that = $(this);
  $.ajax({
    url:apiPath('general-get-car-type/'+that.val()+'/animals'),
    dataType:'JSON',
    success:function(res){
      let driver_animals = jQuery.parseJSON($('[name=current_animals]').val());
      
      $('#available_animals_select').find('select').html('');

      for(let i=0;i<res.data.length;i++){
        let animal = res.data[i];
        let option = "<option></option>";
        
        for(let k=0;k<driver_animals.length;k++){
          if(driver_animals[k].id==animal.id){
            option = "<option selected></option>";            
          }
        }
        $('#available_animals_select').find('select').append($(option).val(animal.id).html(animal.title));
       }
    }
  });
});


$(window).on('shown.bs.modal', function() { 
  let driver_animals = jQuery.parseJSON($('[name=current_animals]').val());
  console.log(driver_animals);
  $('#available_animals_select').find('option').each(function(){
    let current_option = $(this);
    for(let k=0;k<driver_animals.length;k++){
      console.log('K: '+k+', currentOption: '+current_option.val()+', animal'+driver_animals[k].id);
      if(current_option.val() == driver_animals[k].id){
        current_option.replaceWith("<option selected value='"+current_option.val()+"'>"+current_option.text()+"</option>")
      }
    }
    
  });
});


});