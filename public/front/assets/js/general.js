
function disableAll(){
 $('.btn').attr('disabled','disabled');
 $(':input').attr('disabled','disabled');
}

function enableAll(){
 $('.btn').removeAttr('disabled');
 $(':input').removeAttr('disabled');
}

function hidePopluatedErrorMsgs(){

}

function populateErrorMsgs(errors){}

$.ajaxSetup({
 beforeSend: function (xhr){
  hidePopluatedErrorMsgs();
  disableAll();
  xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
  console.log($('meta[name="csrf-token"]').attr('content'));
 },
 error:function(res){
  populateErrorMsgs(res.responseJSON.errors);
 },
 complete:function(){
  enableAll();
  $('select').select2();
 },
 dataType:'JSON'
});
