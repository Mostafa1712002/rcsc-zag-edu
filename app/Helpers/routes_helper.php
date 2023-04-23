<?php
    function spark_getNotificationLink($event_type,$subject_id,$notification_id){
        if(in_array($event_type,['new_ad','new_comment','new_like','new_abuse','edit_ad','new_comment_reply'])){
            $route = route('show_ad',$subject_id);
        }
        return $route.'?read_notification='.$notification_id;
    }
