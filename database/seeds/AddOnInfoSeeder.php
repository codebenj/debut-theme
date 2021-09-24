<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddOnInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addOnInfoArr = [
           2 => [
              "name" => "Live View",
              "addon_settings_title" => "dbtfy_live_view",
              "description" => "Display the number of people viewing your product page.",
              "wistia_video_id" => "n6blebzw6k",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/Mu1y7oPfI2hhG1yPehtZ2tYmFNAi6klbC5hVtGk4.svg"
           ],
           3 => [
              "name" => "Cookie Box",
              "addon_settings_title" => "dbtfy_cookie_box",
              "description" => "Display a Cookie Box to make your website GDPR compliant.",
              "wistia_video_id" => "rawzha2vqa",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/uewvf6zL4bT07HHa3ENIRsuF2OLJebCUTVUo5bb2.svg"
           ],
           4 => [
              "name" => "Delivery Time",
              "addon_settings_title" => "dbtfy_delivery_time",
              "description" => "Display an approximate date of delivery.",
              "wistia_video_id" => "kq1pbpgbnn",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/Tz3dTGMh6nw4UgxEJcMFdNQlaUSbCThZik3i02k3.svg"
           ],
           5 => [
              "name" => "Add-To-Cart Animation",
              "addon_settings_title" => "dbtfy_addtocart_animation",
              "description" => "Add an animation to the product page Add-To-Cart button.",
              "wistia_video_id" => "j32w54qlh9",
              "cost" => 39.48,
              "conversion_rate" => 0.12,
              "icon_path" => "public/uploads/gsnTkTNu0LtPsjKoTAQJ2yC5kXwwLUVZ3Xjx2Usv.svg"
           ],
           6 => [
              "name" => "Sales Pop",
              "addon_settings_title" => "dbtfy_sales_pop",
              "description" => "Showcase your store's recent purchases to all visitors.",
              "wistia_video_id" => "snhgnukyuk",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/XN7eUQROBWQrS0UnpygStupgI8x9bn3PdkmsRFLt.svg"
           ],
           8 => [
              "name" => "Facebook Messenger",
              "addon_settings_title" => "dbtfy_facebook_messenger",
              "description" => "Add a Facebook Messenger chat widget to your store.",
              "wistia_video_id" => "a4singceo9",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/sRABu4HerBIeQhxMq4BWotuKnpKRX2LogqFXlXCQ.svg"
           ],
           9 => [
              "name" => "FAQ",
              "addon_settings_title" => "dbtfy_faq_page",
              "description" => "Add a searchable question and answers module to your store.",
              "wistia_video_id" => "dmpt61p9a5",
              "cost" => 23.88,
              "conversion_rate" => 0.07,
              "icon_path" => "public/uploads/tONlM8RdHJoN6oDspu2hj8b6sAF40Ot3fnV56OSU.svg"
           ],
           10 => [
              "name" => "Sticky Add-To-Cart",
              "addon_settings_title" => "dbtfy_sticky_addtocart",
              "description" => "Add a Sticky Add-To-Cart bar when scrolling past the Add-To-Cart button.",
              "wistia_video_id" => "3yb0irbb81",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/D8OQl9PCzTUDs2OSkMNi9dg7eN1BJikVO2eCHbKX.svg"
           ],
           12 => [
              "name" => "Shop Protect",
              "addon_settings_title" => "dbtfy_shop_protect",
              "description" => "Protect your product description, images, articles, and other content from being stolen.",
              "wistia_video_id" => "a27ikz4rd3",
              "cost" => 47.88,
              "conversion_rate" => 0.39,
              "icon_path" => "public/uploads/xEgzrTlwFbvdLNw8aeSC6xwcBLw1a7ztwjxWbKnj.svg"
           ],
           13 => [
              "name" => "Mega Menu",
              "addon_settings_title" => "dbtfy_mega_menu",
              "description" => "Add nested menus, products, collections, articles, and more to your header navigation.",
              "wistia_video_id" => "g3926xxj6a",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/lnHwY8BvzKWEbEuXQmMiJGGS7iz1LyXAls3QPRy9.svg"
           ],
           14 => [
              "name" => "Newsletter Pop-Up",
              "addon_settings_title" => "dbtfy_newsletter_popup",
              "description" => "Display a customizable Newsletter Pop-Up to capture your visitor's email before they leave your store.",
              "wistia_video_id" => "hx3g7pvxzv",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/UP3NiGcQM9i3T8ldBExBQBLHpfWMFIoJlA5OdsvK.svg"
           ],
           15 => [
              "name" => "Collection Add-To-Cart",
              "addon_settings_title" => "dbtfy_collection_addtocart",
              "description" => "Allow visitors to add products to the cart directly from collection pages.",
              "wistia_video_id" => "gscpxqg02d",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/KXw6BjakZXiLuoodemZLXBhow4yMGMIHaBvCMinW.svg"
           ],
           16 => [
              "name" => "Upsell Pop-Up",
              "addon_settings_title" => "dbtfy_upsell_popup",
              "description" => "Display a customizable Upsell Pop-Up that triggers when adding a product to the cart.",
              "wistia_video_id" => "arlr3stk4r",
              "cost" => 17.88,
              "conversion_rate" => 0.03,
              "icon_path" => "public/uploads/mx2KTMKYF5mfXs57coPYj0RuR91kIPh1Yl7F5jb2.svg"
           ],
           17 => [
              "name" => "Discount Saved",
              "addon_settings_title" => "dbtfy_discount_saved",
              "description" => "Display the discount amount of on-sale product variants on the product page.",
              "wistia_video_id" => "x2o9y47c7z",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/gPow7MpxgXRETjEZOGwMMFbxja9HEtFKXiwCEzsQ.svg"
           ],
           19 => [
              "name" => "Inventory Quantity",
              "addon_settings_title" => "dbtfy_inventory_quantity",
              "description" => "Display the stock level for each product variant.",
              "wistia_video_id" => "adib9cnhi2",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/brdSyZY3i7zscw3LTt3Ol1Wt5vINVP3e4jy8Xik0.svg"
           ],
           20 => [
              "name" => "Linked Options",
              "addon_settings_title" => "dbtfy_linked_options",
              "description" => "Hide unavailable product variant combinations.",
              "wistia_video_id" => "uwkntrqfo0",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/ycTHrFzqOFfS2RYBYnH4kOqeryvDogw1VFUOVmXc.svg"
           ],
           21 => [
              "name" => "Cart Countdown",
              "addon_settings_title" => "dbtfy_cart_countdown",
              "description" => "Display a Countdown Timer in the cart.",
              "wistia_video_id" => "pbu1gnzb4p",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/5PrlkYmEuQ5mnZ31kL8hoXmR15hGqVnYjmxleRcX.svg"
           ],
           22 => [
              "name" => "Color Swatches",
              "addon_settings_title" => "dbtfy_color_swatches",
              "description" => "Add Color Swatches to your product options.",
              "wistia_video_id" => "e5wgxlb6x7",
              "cost" => 11.88,
              "conversion_rate" => 0.07,
              "icon_path" => "public/uploads/HCkuxUoudRA0RUInXBcTsV8Up3zWfdN5yujZa5Vt.svg"
           ],
           23 => [
              "name" => "Cart Discount",
              "addon_settings_title" => "dbtfy_cart_discount",
              "description" => "Allow customers to enter discount codes in the cart before checkout.",
              "wistia_video_id" => "79lutbvt1p",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/RK0FtgsxOOocujiS2LSbQX5Zssht6VC4C0XB3XHu.svg"
           ],
           24 => [
              "name" => "Upsell Bundles",
              "addon_settings_title" => "dbtfy_upsell_bundles",
              "description" => "Let customers buy different products in one click by creating bundle offers.",
              "wistia_video_id" => "2e26wpgp65",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/5SWUNzOmXdbgxhqaYlUdElS1uRotexO2VPrkWHjz.svg"
           ],
           26 => [
              "name" => "Smart Search",
              "addon_settings_title" => "dbtfy_smart_search",
              "description" => "Show search results immediately as you type into the search field.",
              "wistia_video_id" => "2aphc3nw4b",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/YfWrOVHJGn6L7v50mqg0647lFbDiwndrJV6D47BQ.svg"
           ],
           27 => [
              "name" => "Quick View",
              "addon_settings_title" => "dbtfy_quick_view",
              "description" => "Let customers quickly view your product details before they visit the product page.",
              "wistia_video_id" => "l34ptzy7ab",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/i9G2Ve1B04BUePna5mQfFoA8xaWiTzasqfN0EebS.svg"
           ],
           28 => [
              "name" => "Cart Goal",
              "addon_settings_title" => "dbtfy_cart_goal",
              "description" => "Offer free shipping when a specific cart total amount is reached.",
              "wistia_video_id" => "srsoztyste",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/Q5ckUYCLDdlyPlyeqTC1OFZlZ61qi3MDSEvOzey8.svg"
           ],
           29 => [
              "name" => "Pricing Table",
              "addon_settings_title" => "dbtfy_pricing_table",
              "description" => "Showcase product options, bundles, packages, and all other upgrade options in a side-by-side price comparison table.",
              "wistia_video_id" => "qln0c9qsvg",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/lfQ5A8M9j3K0EFRV9NpzBcx9UjuPDVEFHI53Qc4r.svg"
           ],
           30 => [
              "name" => "Wish List",
              "addon_settings_title" => "dbtfy_wish_list",
              "description" => "Let customers add their favorite products to a Wish List they can come back to later.",
              "wistia_video_id" => "cmxwwaylb3",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/erMaaZ0x0TJrW0jxdTGngXKTxhOuwO7a0j4j4uWs.svg"
           ],
           31 => [
              "name" => "Quantity Breaks",
              "addon_settings_title" => "dbtfy_quantity_breaks",
              "description" => "Reward customers with discount codes when they purchase multiple items from your store.",
              "wistia_video_id" => "859sacjp5o",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/JH8pdZ9YmSKGaudPSxI0i4lbhyoSspCl9MSwDQq1.svg"
           ],
           32 => [
              "name" => "Order Tracking",
              "addon_settings_title" => "dbtfy_order_tracking",
              "description" => "Let your customer track their orders directly from within your store.",
              "wistia_video_id" => "yocgvklgl4",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/KHrDFrFayJ8ibZ5BOWhJzJpdUxM0Qf9DHwwpSKQY.svg"
           ],
           33 => [
              "name" => "Automatic Geolocation",
              "addon_settings_title" => "dbtfy_automatic_geolocation",
              "description" => "Add ability to set default language and currency based on user location.",
              "wistia_video_id" => "oz6zgufbpp",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/3lEOGezP8unIBx956qqGvlbEPmxuA05NoeU9uiyn.svg"
           ],
           34 => [
              "name" => "Recently Viewed",
              "addon_settings_title" => "dbtfy_recently_viewed",
              "description" => "Display the products a visitor has seen while browsing your store.",
              "wistia_video_id" => "4xame4nc7h",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/O21l22C8Hy7owCOdB8eUc0au1cczUNutkHNCh6MZ.svg"
           ],
           35 => [
              "name" => "Page Transition",
              "addon_settings_title" => "dbtfy_page_transition",
              "description" => "Display a preloader with your logo while the page is loading.",
              "wistia_video_id" => "mzecm3qmum",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/mZkEJcpsX4LeSpIh8PWNgduyixLDTiOOt0n9wlse.svg"
           ],
           36 => [
              "name" => "Cart Upsell",
              "addon_settings_title" => "dbtfy_cart_upsell",
              "description" => "Add up-sells and cross-sells directly in your cart.",
              "wistia_video_id" => "v82z8bl5vw",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/5Ptv9MbKNU9byZu6CaVWRvBGLWGt8kTi5PHzeg2F.svg"
           ],
           37 => [
              "name" => "Custom Currencies",
              "addon_settings_title" => "dbtfy_custom_currencies",
              "description" => "Show prices in multiple currencies without having to use Shopify Payment multi-currency converter.",
              "wistia_video_id" => "cew9cwy4mo",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/xpBHsokxBrU2J0CTDjapNSy9aACRVLwUtPacdOJN.svg"
           ],
           40 => [
              "name" => "Cart Savings",
              "addon_settings_title" => "dbtfy_cart_savings",
              "description" => "Display the total amount of savings in the cart.",
              "wistia_video_id" => "2kwh3fynlf",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/qg7hG4rJpnKr967MtP3BsbAWGTPPDbLKyTsBx13G.svg"
           ],
           41 => [
              "name" => "Back In Stock",
              "addon_settings_title" => "dbtfy_back_in_stock",
              "description" => "Allow customers to fill back in the stock request form.",
              "wistia_video_id" => "4ec6ckkdl9",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/ioMd1mZMwzYAfSiKls0S7Sptbeoe1ZiFGizqZnTJ.svg"
           ],
           42 => [
              "name" => "Agree To Terms",
              "addon_settings_title" => "dbtfy_agree_to_terms",
              "description" => "Ask customers to agree with your Terms & conditions before checking out.",
              "wistia_video_id" => "yg6d27rzxf",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/wT7LP9VWkOzqRN4ZwlodF6PK9GjFhSN2r9hwTsa1.svg"
           ],
           43 => [
              "name" => "Age Check",
              "addon_settings_title" => "dbtfy_age_check",
              "description" => "Verifies the age of website visitors before they can access your content and products.",
              "wistia_video_id" => "a4vtlz33bq",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/dyFBihBXk0CrPN9TVS9g44EjN2XwyJuTKdc9dx7o.svg"
           ],
           44 => [
              "name" => "Cart Favicon",
              "addon_settings_title" => "dbtfy_cart_favicon",
              "description" => "Change the page favicon to a secondary image if there is a product in the cart.",
              "wistia_video_id" => "kteltfik2b",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/17kPrP1tiEnqvnmFpR2yYSswrvHLFfpa6NvTADa0.svg"
           ],
           45 => [
              "name" => "Order Feedback",
              "addon_settings_title" => "dbtfy_order_feedback",
              "description" => "Find out how your customers know about you.",
              "wistia_video_id" => "4d3914oto2",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/zvoS8YqjLAgrS5Vcm52bvtUfesa0GIXMLo4m3Nnt.png"
           ],
           46 => [
              "name" => "Inactive Tab Message",
              "addon_settings_title" => "dbtfy_inactive_tab_message",
              "description" => "Display a different page title when the user goes to another tab.",
              "wistia_video_id" => "t6t40emgif",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/z9DbKi129Z7LLztLAd4U1wX2iV07Lq31Y5j3t1PP.png"
           ],
           48 => [
              "name" => "Product Image Crop",
              "addon_settings_title" => "dbtfy_product_image_crop",
              "description" => "Format all your product images into the same ratio.",
              "wistia_video_id" => "ht13z77nnw",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/j3jFH986IvJhbm6aBWsEzgKhiYrLNclVARgLxYya.png"
           ],
           49 => [
              "name" => "Size Chart",
              "addon_settings_title" => "dbtfy_size_chart",
              "description" => "Add customizable size guides with tables and images to your product pages.",
              "wistia_video_id" => "bvgdafh65n",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/mX9N4OsY29aOMFEk4IfDHGGPS9ySIQRS6SCQsCdT.png"
           ],
           50 => [
              "name" => "Collection Filters",
              "addon_settings_title" => "dbtfy_collection_filters",
              "description" => "Allow visitors to filter the products on the collection page by the parameters they want.",
              "wistia_video_id" => "dzfk9dboix",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/d0Ho7ILqp3W6QHrTZltx19k6sOtoKWr1aCREHvqx.svg"
           ],
           51 => [
              "name" => "Instagram Feed",
              "addon_settings_title" => "dbtfy_instagram_feed",
              "description" => "Display the latest images of your Instagram page.",
              "wistia_video_id" => "jf82ft1d5c",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/vEblgTFa8HJzmOVLNKpFb8Hhb4r2DEtrUbYkhWFb.png"
           ],
           52 => [
              "name" => "Product Bullet Points",
              "addon_settings_title" => "dbtfy_product_bullet_points",
              "description" => "Add short, easily digestible pieces of information about your products.",
              "wistia_video_id" => "khvdvg9ens",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/MGzC5NpNfaol8uapY3gBf5928nQ7DzJx9PAxYdd1.png"
           ],
           53 => [
              "name" => "Page Speed Booster",
              "addon_settings_title" => "dbtfy_page_speed_booster",
              "description" => "Improve your conversion rate by making your store faster.",
              "wistia_video_id" => "k7qb21yqrg",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/GGRbltwf36wGc0e5jJr4heSy8aKi9ySw1j0HV0Gy.png"
           ],
           54 => [
              "name" => "Menu Bar",
              "addon_settings_title" => "dbtfy_menu_bar",
              "description" => "Add a simple scrollable menu below the header.",
              "wistia_video_id" => "msxsm3sv5h",
              "cost" => 35.88,
              "conversion_rate" => 0.15,
              "icon_path" => "public/uploads/U2X5a7NejmIUkxHxiSn6ICCDxqtrnjA1Pt3zkt0Q.png"
          ]
        ];

        foreach($addOnInfoArr as $key => $addOnInfo) {
            \App\AddOnInfo::updateOrCreate(['id' => $key],$addOnInfo);
        }
    }
}
