window.termLocation='startsWith';
// window.pageData.order_by = 'id';
// window.pageData.order_type='desc';


$(document).ready(function(){
  $('.termLocation-btn').first().addClass('btn-primary');
});


let orders = [];

function populateErrorMsgs(msgs){
 for(field in msgs){
  var errorMsgs = msgs[field];
  $('[name='+field+']').parents('.form-group').find('.invalid-feedback').text(errorMsgs).show();
 }
}

function hidePopluatedErrorMsgs(){
 $('.invalid-feedback').hide();
}

function disableAll(){
 $(':input').attr('disabled','disabled');
 $('a').attr('disabled','disabled');
 $('button').attr('disabled','disabled');
}

function enableAll(){
 $(':input').removeAttr('disabled');
 $('a').removeAttr('disabled');
 $('button').removeAttr('disabled');
}


function showAlert(type,id,msg){
 enableAll();
 if(type=='ok'){
  alertOK(id,msg);
 }else{
  alertError(id,msg);
 }
}

function alertOK(alertID,msg){
 $('#'+alertID+'-alert-ok').fadeIn();
 $('#'+alertID+'-alert-ok').find('span').text(msg);
 setTimeout(function(){
  $('#'+alertID+'-alert-ok').fadeOut();
 },1500);
}

function alertError(alertID,msg){
 $('#'+alertID+'-alert-error').fadeIn();
 $('#'+alertID+'-alert-error').find('span').text(msg);
 setTimeout(function(){
  $('#'+alertID+'-alert-error').fadeOut();
 },1500);
}


$('body').delegate('.termLocation-btn','click',function(e){
 e.preventDefault();
 window.termLocation = $(this).data('location');
 $('.termLocation-btn').removeClass('btn-primary').addClass('btn-default');
 $(this).addClass('btn-primary');
});



$('body').delegate('#reset-filter-records-btn','click',function(e){
 e.preventDefault();
 $('#filter-inputs-form').trigger("reset");
});

$('body').delegate('.remove-record-btn','click',function(e){
 e.preventDefault();
 var that = $(this);
 window.current_record = parseInt(that.data('id'));
 //var r = confirm($('#data-div').data('confirm-msg'));

 $.confirm({
  title: $('#data-div').data('are-you-sure'),
  content: $('#data-div').data('confirm-msg'),
  buttons: {
    confirm:{
     text:$('#data-div').data('delete'),
     btnClass:'btn btn-danger',
     action:function () {
      $.ajax({
       url:adminPath(window.pageData.controller+'/'+window.current_record),
       type:'DELETE',
       success:function(res){
        if(res.logout != null && res.logout ==1){
         window.location.href = publicPath('login');
        }else if(res.status != null && res.status==0){
         alert(res.msg);
        }else{
         window.pageMethods.filterRecords();
        }
       },
       error:function(res){
        $.alert(res.responseJSON.msg);
       }
      });/*Ajax*/
     }/*function*/
    },

    cancel:{
     text:$('#data-div').data('cancel'),
     btnClass:'btn btn-default',
     action(){}
    }
  }
});


});/**/

$('body').delegate('.order-th','click',function(e){
 let that = $(this);
 let order_by = that.data('order-by');

 let is_found = 0;
 let order_type = 'asc';

 for(let i=0;i<orders.length;i++){
  if(orders[i].order_by == order_by){
   order_type = (orders[i].order_type=='asc')? 'desc' : 'asc';
   orders[i].order_type = order_type;
   is_found=1;
   break;
  }
 }

 if(is_found==0){
  orders.push({'order_by':order_by,'order_type':order_type});
 }

 window.pageData.order_by = order_by;
 window.pageData.order_type = order_type;
 window.pageMethods.filterRecords();
});

$('body').delegate(':input','keyup',function(e){
  let that = $(this);
  if(that.val().indexOf('/>')!=-1){
    that.parents('.form-group').find('.invalid-feedback').addClass('contains-html').show().text('Invalid format');
  }else{
    that.parents('.form-group').find('.contains-html').removeClass('contains-html').hide();
  }
});

$('.show-eye-btn').click(function(){
    let that = $(this);
    let related_element = $('[name='+that.data('related-element')+']');
    if(related_element.attr('type') == 'text'){
        related_element.attr('type','password');
        that.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
    }else{
        related_element.attr('type','text');
        that.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    }
});
