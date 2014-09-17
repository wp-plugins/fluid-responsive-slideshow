<tr class='list_item' id="list_item_<?php echo $post->ID ?>" style="background-color:#F9F9F9;">  
    <td class='frs_td_container'>
        <div class='frs_slide_thumbnail'>
        <?php

            $thumb_img = get_the_post_thumbnail(get_the_ID(),'medium');     

            if(! empty($thumb_img))
            {
                echo "<a href='" . get_edit_post_link(get_the_ID()) . "'>" . $thumb_img . "</a>";
            }
            else
            {
                $postmeta = get_post_meta(get_the_ID(), 'tonjoo_frs_meta',true);

                if (!isset($postmeta["slider_bg"] )) $postmeta["slider_bg"] = "#000000";

                echo "<div style='height:200px;width:300px;background-color:{$postmeta["slider_bg"]};'></div>";
            }
        ?>

        </div>
        <div class='frs_slide_info'>
        <h3><?php the_title() ?></h3>
        <?php echo apply_filters('the_content',$post->post_content) ?>
        </div>
        <div class='frs_slide_edit'>           
            <a class='button button-frs button-primary button-large' frs-edit-slide data-post-id='<?php echo the_ID() ?>'>Edit Slide</a><span class="spinner frs-button-spinner" ></span><br><br>    
            <a href='<?php echo $edit ?>'  target='_blank' class='button-frs  button  button-large' >Edit Slide In New Tab</a><br><br>            
            <a class='button button-frs  button-danger button-large' data-post-id='<?php echo the_ID() ?>'frs-delete-slide>Delete Slide</a><span class="spinner frs-button-spinner" ></span><br>
        </div>
    </td>
</tr>  