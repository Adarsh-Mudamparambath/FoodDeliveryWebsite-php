<?php

include 'connect.php'; // Include the connection to the database

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location:../home.php');
    exit();
}

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Fetch the order details from the orders table
    $select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ? AND user_id = ?");
    $select_order->execute([$order_id, $user_id]);

    if ($select_order->rowCount() > 0) {
        $order_data = $select_order->fetch(PDO::FETCH_ASSOC);

        // Parse `total_products` to get individual products and their quantities
        $products = explode(' - ', $order_data['total_products']);

        foreach ($products as $product) {
            if (!empty($product)) {
                list($product_name, $details) = explode('(', $product);
                $details = rtrim($details, ')'); // Remove closing parenthesis
                list($price, $quantity) = sscanf($details, "%d x %d");

                // Fetch product information from products table
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE `name` = ?");
                $select_product->execute([trim($product_name)]);
                $product_info = $select_product->fetch(PDO::FETCH_ASSOC);

                if ($product_info) {
                    $product_id = $product_info['id'];
                    $product_image = $product_info['image'];

                    // Check if product already exists in the user's cart
                    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND pid = ?");
                    $select_cart->execute([$user_id, $product_id]);

                    if ($select_cart->rowCount() > 0) {
                        // If the product already exists in the cart, update the quantity
                        $cart_item = $select_cart->fetch(PDO::FETCH_ASSOC);
                        $new_quantity = $cart_item['quantity'] + $quantity;
                        $update_cart = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
                        $update_cart->execute([$new_quantity, $cart_item['id']]);
                    } else {
                        // Insert the product as a new cart item
                        $add_to_cart = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
                        $add_to_cart->execute([$user_id, $product_id, trim($product_name), $price, $quantity, $product_image]);
                    }
                }
            }
        }

        // Redirect to checkout page after reordering
        header('location:../checkout.php');
        exit();
    } else {
        // Order does not exist or doesn't belong to the user
        $_SESSION['message'] = 'Failed to reorder. Please try again!';
        header('location:../orders.php');
        exit();
    }
} else {
    // Redirect back if no order_id was sent
    header('location:../orders.php');
    exit();
}
?>
