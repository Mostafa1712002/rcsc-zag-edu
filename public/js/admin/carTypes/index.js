$(document).ready(function(){      
 window.pageData={
   controller:'carType',
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
         'title_ar':$('[name=filter-title_ar]').val(),
         'title_en':$('[name=filter-title_en]').val(),
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
       adminPath(window.pageData.controller+'/'+current_record) : adminPath(window.pageData.controller);

   var type = (current_record)? 'PUT' : 'POST';
   $.ajax({
     url:route,
     type:type,
     data:$('#man-'+window.pageData.controller+'-form').serialize(),
     success:function(res){
       var alertType = (res.status)? 'ok' : 'error';
       showAlert(alertType,'man-'+window.pageData.controller,res.msg);
       setTimeout(function(){
         $('#edit-record-modal').modal('hide');
       },2000);
       pageMethods.filterRecords();
     }/**/
   });/*Ajax*/
 });


 $('body').delegate('.animals-btn','click',function(e){
  e.preventDefault();
  let that = $(this);
  current_record = parseInt(that.data('id'));
  $.ajax({
    url:adminPath(window.pageData.controller+'/'+current_record+'/animals'),
    dataType:'HTML',
    success:function(res){
      $('#edit-record-modal').find('.modal-body').html(res);
      $('#edit-record-modal').modal('show');
      $('#edit-record-modal').find('#save-record-btn').attr('id','save-animals-btn');
      $('select').select2();
     },
     errors(){}
  });


  $('body').delegate('#save-animals-btn','click',function(e){
    e.preventDefault();
    $.ajax({
      url:adminPath(window.pageData.controller+'/'+current_record+'/animals'),
      type:'PUT',
      data:$('#man-carType-animals-form').serialize(), 
      success:function(res){
        alertOK('man-animals',res.msg);
        setTimeout(function(){
          window.pageMethods.filterRecords();
          $('#edit-record-modal').modal('hide');          
        },1000);
      }
    });
  })
 });



});