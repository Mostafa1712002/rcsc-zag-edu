<?php
    function spark_starsRating($rating=0){
        $rating = round($rating,2);
        $html= '
            <span class="float-start">
                <div class="rating pt-0 rating-'.$rating.'">';
        for($i=1;$i<6;$i++){
            $html .= '<span class="fa fa-star '.($i<=ceil($rating)? 'checked' : '').'"></span>';
        }

        $html .= '<span>('.$rating.')</span>
            </div>
            </span>
        ';
        return $html;
    }
