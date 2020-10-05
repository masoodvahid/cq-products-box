<div class='row mt-3'>
<?php 
foreach($results as $result){ 
    if($result->products[0]->id){ 
    ?>
<div class="col-12 col-md-6">
    <div class='card mb-4'>
        <div class='row no-gutters'>
            <div 
                class='col-12 col-md-6 box-image-holder' 
                id="box-image-holder" 
                style="background-image: url('<?php if($result->products[0]){ echo wp_get_attachment_url( $result->products[0]->get_image_id() );} ?>"')">
            <a id="box-image-holder-link" href="<?php echo get_permalink($result->products[0]->get_id() ); ?>">
                <img class="watermark" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/img/watermark.png'; ?>" >
                <img class="watermark-so" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/img/watermark-so.png'; ?>" style="display: none;">
            </a>                    
            </div>                
            <div class='col-12 col-md-6 d-flex p-4'>
                <div class='card-block  px-2'>                        
                    <a class="card-box-title text-danger" href="<?php echo site_url($result->link.$result->slug); ?>"><?php echo $result->name ?> </a>
                        <!-- <span class='badge badge-primary  align-top'><?php echo $result->count; ?></span>                       -->
                        <h1 class="card-title pt-2" id="card-title"></h1>
                        <div class="card-price"><span class="text-danger" id="card-sale-price"></span> <span id="card-price"></span></div>
                    <div class="py-2">
                    <?php 
                    
                        $i = 1;
                        $j = 1;
                            foreach ($result->products as $product) {    
                                $attribute = $product->get_attributes();
                                // print_r($attribute);
                                $dimensions = false;
                                if($attribute['length']['options'][0] && $attribute['height']['options'][0] && $attribute['thickness']['options'][0]){
                                    $dimensions = "<h3>Dimensions:</h3>".$attribute['length']['options'][0]." x ".$attribute['height']['options'][0]." x ".$attribute['thickness']['options'][0];
                                }
                                
                                ?>                                
                                <img id="slide_<?php if($i%24 == 0){$j++;} echo $j;?>" class="product-thumbnail rounded-circle mr-1 mb-2"                                       
                                    src="<?php echo wp_get_attachment_thumb_url( $product->get_image_id() ); ?>" 
                                    alt="<?php echo $product->name; ?>" 
                                    title="<?php echo $product->name; ?>"
                                    data-src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>"
                                    data-link="<?php echo get_permalink($product->get_id() );?>"
                                    data-price="<?php echo $product->price; ?>"
                                    data-sale-price="<?php echo $product->sale_price; ?>"
                                    data-regular-price="<?php echo $product->regular_price; ?>"
                                    data-dimensions="<?php echo $dimensions; ?>"
                                    >                                     
                    <?php 
                                $i++;
                            }
                    
                    ?>
                    </div>
                    
                    <div class="dimensions text-danger"></div>
                    <!-- <a id="card-button" class="btn btn-primary mt-auto" href="<?php echo site_url($result->link); ?>">View Details</a> -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php    
    } 
}
?>
</div>

<script>
    jQuery(document).ready(function($){

        $(".product-thumbnail").click( function(){             
            var thisCard = $(this).closest('.card');
            var thumbnail = $(this).data("src");
            var link = $(this).data("link");
            var title = $(this).attr('title');
            var price = $(this).data('price');
            var sale_price = $(this).data('sale-price');            
            var regular_price = $(this).data('regular-price');
            var dimensions = $(this).data('dimensions');

            thisCard.find("#card-price , #card-sale-price").removeClass("card-text-line-through").text('');
            thisCard.find('.box-image-holder').css("background-image", "url("+thumbnail+")");
            thisCard.find("#box-image-holder-link, #card-button").attr("href", link);
            thisCard.find("#card-title").text(title);
            thisCard.find(".dimensions").html(dimensions);
            if(sale_price>0){
                thisCard.find("#card-price").text("$"+regular_price).addClass("card-text-line-through");
                thisCard.find("#card-sale-price").text("$"+sale_price);
                thisCard.find(".watermark").hide();
                thisCard.find(".watermark-so").show();
            }else if(price>0){
                thisCard.find(".watermark").show();
                thisCard.find(".watermark-so").hide();
                thisCard.find("#card-price").text("$"+price);
            };
        })        
    });
</script>