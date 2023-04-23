

function getCRUDModal(route){
 $.ajax({
  url:route,
  dataType:'HTML',
  success:function(res){
   $('#edit-record-modal').find('.modal-body').html(res);
   $("#edit-record-modal").modal('show');
  }
 });
}/*getEditModal*/

function remove(recordID=0){
 var confirmation = confirm(getMsg('areYouSure'));
 if(confirmation){
  $.ajax({
   url:route,
   dataType:'JSON',
   success:function(res){
    filterRecords();
   },
   error:alert(res.responseJSON.msg)
  });/*Ajax*/
 }/**/
}/*remove*/

$('body').delegate('.edit-record-btn','click',function(e){
 e.preventDefault();
 var that = $(this);
 currentRecord = parseInt(that.data('id'));
 window.pageData.currentRecord = currentRecord;
 var controller = window.pageData.controller;
 var route = 
   (currentRecord)?
     adminPath(controller+'/'+currentRecord+'/edit') : adminPath(controller+'/create');
 getCRUDModal(route);
});/*del*/

$('body').delegate('.remove-record-btn','click',function(e){
  e.preventDefault();
  var that = $(this);
  currentRecord = parseInt(that.data('id'));
  var controller = window.pageData.controller;
  var route =  adminPath(controller+'/'+currentRecord) ;
  var r = confirm('Are you sure?');
  if(r){
    $.ajax({
      url:route,
      type:'DELETE',
      success:function(res){
        enableAll();
        window.pageMethods.filterRecords();
      }/*success*/
    });
  }/*confirmed*/
  
 });/*del*/
 
 

$('body').delegate('#filter-records-btn','click',function(e){
 e.preventDefault();
 pageData.currentPage=0;
 pageMethods.filterRecords();
});/*dele*/

$('body').delegate('.pagination-btn','click',function(e){
 var that = $(this);
 window.pageData.currentPage = parseInt(that.data('page'));
 pageMethods.filterRecords();
});