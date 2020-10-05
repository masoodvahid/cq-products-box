<?php

use Automattic\WooCommerce\Admin\API\Products;

if (!class_exists('ProductsBox')) :
    class ProductsBox
    {   
        private $categories;
        private $products;

        function __construct()
        {
            add_shortcode('cq-show-card', [$this, 'show_card']);
            add_shortcode('cq-show-slide', [$this, 'show_slide']); 
            add_action( 'cq_products_box_slideshow' , [$this,'show_under_single_product'], 5 );
        }

        public static function get_categories($input = false){                    

            if ( $input['slug'] ) {               
                $slugs = array_map( 'trim', str_getcsv( $input['slug'], ',' ) );
            }
                        
            foreach( $slugs as $slug){
                $results[$slug] = get_term_by('slug', $slug, 'product_cat');
                $results[$slug]->link = get_option('woocommerce_permalinks')['category_base'] .'/';
                $results[$slug]->products = self::get_products($slug);                 
            }            
            return $results;
        }

        public static function get_products($slug){
            $args = array(                
                'category'  => $slug,
                'status'    => "publish",
                'limit'     => 35,                    
            );
            return wc_get_products($args);            
        }

        public static function show_card($atts = false)
        {                 
            $results = self::get_categories($atts);            
            require_once(PRODUCTS_INLINE_DIR . 'views/products-box-card-view.php');            
        }

        public static function show_slide($atts)
        {
            require_once(PRODUCTS_INLINE_DIR . 'views/products-box-slideshow-view.php');
        }
            
        public static function show_under_single_product() {
            global $product;            
            $current_product_category_details = get_the_terms ( $product->id, 'product_cat' );
            $input['slug'] = $current_product_category_details[0]->slug;
            $results = self::get_categories($input);            
            require_once(PRODUCTS_INLINE_DIR . 'views/products-box-slideshow-view.php');             
        }
    }
    $pi = new ProductsBox;    
endif;
