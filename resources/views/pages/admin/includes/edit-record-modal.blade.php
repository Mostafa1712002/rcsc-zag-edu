<div class="modal fade" id="edit-record-modal" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <h4 class="modal-title pull-left" id="myModalLabel">
         <i class="glyphicon glyphicon-cog"></i>
         <?php echo __('general.control'); ?>
       </h4>
     </div>
     <div class="modal-body">
       
     </div><!-- Modal-body-->
     <div class="modal-footer">        
       
       <?php
         echo spark_btn([
           'title'=>__('general.save'),
           'pull'=>'left',
           'class'=>'success btn-block',
           'id'=>'save-record-btn',
           'size'=>'lg'
         ]);/*sparkBtn*/
       ?>
       <div class="clearfix"></div>
     </div><!-- Modal footer-->
   </div>
 </div>
</div><!--End modal -->