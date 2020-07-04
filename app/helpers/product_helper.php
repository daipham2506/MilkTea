<?php 
    //echo star rely on star count
    function printStar($avgStar){
        $num_star = 0;
        $star_html = "";
        while($num_star < floor($avgStar)){
            $star_html .= "<i class='fas fa-star color-yellow'></i>";
            $num_star++;
        }
        //add half star
        if($avgStar - $num_star > 0){
            $star_html.= "<i class='fas fa-star-half-alt color-yellow'></i>";
            $num_star++;
        }
        $num_no_star = 0;
        while($num_no_star < 5 - $num_star){
            $star_html.= "<i class='far fa-star color-yellow'></i>";
            $num_no_star++;
        }
        $star_html .= "&nbsp;";
        return $star_html;
    }
?>