$.ajaxSetup({
 beforeSend: function (xhr){
  hidePopluatedErrorMsgs();
  disableAll();
  $('.invalid-feedback').hide();
  xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
  xhr.setRequestHeader('Accept-Language', $('meta[name="accept-language"]').attr('content'));
 },
 error:function(res){
  populateErrorMsgs(res.responseJSON.errors);
 },
 complete:function(){
  enableAll();

 },
 dataType:'JSON'
});
