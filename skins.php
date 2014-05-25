<?php
    /* Penanganan skin khusus */
    $skin_name = $options[$current]['skin'];
    $addon_style .= "";
    $inner_bg = false; /* set to true will set text box background to inner */

    if($skin_name == 'elegant')
    {
        /* number in bullets */
        $query = new WP_Query($condition);
        $i = 1;

        while($query->have_posts())
        {
            $query->the_post();

            $nth_child = "";

            for ($j = 2; $j <= $i; $j++) 
            { 
                $nth_child = $nth_child." + li";
            }

            $addon_style .= "
            #$attr[slide_type_id]-slideshow .frs-bullets-wrapper li.frs-slideshow-nav-bullets$nth_child:after {
                content: \"$i\";
            }";

            $i++;
        }
    }