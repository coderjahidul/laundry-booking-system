<?php
// Delivery van management page
function delivery_van_management_page() {
    add_menu_page(
        'Delivery Van Management',
        'Delivery Van',
        'manage_options',
        'delivery-van-management',
        'delivery_van_admin_page',
        'dashicons-car',
        50
    );
}

add_action('admin_menu', 'delivery_van_management_page');

// Delivery van admin page
function delivery_van_admin_page() {
    // Save form on submit
    if (isset($_POST['delivery_van_submit'])) {
        // Sanitize the input
        $delivery_van = sanitize_text_field($_POST['delivery_van']);

        // Save the option in the database
        update_option('delivery_van', $delivery_van);

        echo '<div class="updated"><p>Delivery Van updated successfully!</p></div>';
    }

    // Get the saved value
    $saved_van = get_option('delivery_van', '2');

    ?>
    <style>
        .delivery-van-box {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .delivery-van-box h3 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
    <div class="wrap">
        <h1 style="text-align:center;">Delivery Van Management</h1>
        <div class="delivery-van-box">
            <form method="post" action="">
                <h3>Set Delivery Van</h3>
                <input type="number" name="delivery_van" value="<?php echo esc_attr($saved_van); ?>" class="regular-text" style="width: 100%;" />
                <?php submit_button('Update Delivery Van', 'primary', 'delivery_van_submit'); ?>
            </form>
        </div>
    </div>
    <?php
}
