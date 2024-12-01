<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'cart item deleted!';
}

if(isset($_POST['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   $message[] = 'deleted all from cart!';
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'cart quantity updated';
}

$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cart</title>

   <!-- Font Awesome CDN Link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File Link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- Header Section Starts  -->
<?php include 'components/user_header.php'; ?>
<!-- Header Section Ends -->

<div class="heading">
   <h3>Shopping Cart</h3>
   <p><a href="home.php">Home</a> <span> / Cart</span></p>
</div>

<!-- Shopping Cart Section Starts  -->

<section class="products">

   <h1 class="title">Your Cart</h1>

   <div class="box-container">

      <?php
         $grand_total = 0;
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('Delete this item?');"></button>
         <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
         <div class="name"><?= $fetch_cart['name']; ?></div>
         <div class="flex">
            <div class="price"><span>₹</span><span class="item-price"><?= $fetch_cart['price']; ?></span></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2" onchange="updateCart(this, <?= $fetch_cart['id']; ?>, <?= $fetch_cart['price']; ?>)">
         </div>
         <div class="sub-total"> Sub Total: <span class="sub-total-price">₹<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
      </form>
      <?php
               $grand_total += $sub_total;
            }
         }else{
            echo '<p class="empty">Your cart is empty</p>';
         }
      ?>

   </div>

   <div class="cart-total">
      <p>Cart Total: <span id="grand-total">₹<?= $grand_total; ?></span></p>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Proceed to Checkout</a>
   </div>

   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('Delete all from cart?');">Delete All</button>
      </form>
      <a href="menu.php" class="btn">Continue Shopping</a>
   </div>

</section>

<!-- Shopping Cart Section Ends -->

<!-- Footer Section Starts  -->
<?php include 'components/footer.php'; ?>
<!-- Footer Section Ends -->

<!-- Custom JS File Link  -->
<script src="js/script.js"></script>

<script>
function updateCart(element, cartId, price) {
   let quantity = element.value;
   let subTotalElement = element.closest('.flex').nextElementSibling.querySelector('.sub-total-price');
   let newSubTotal = quantity * price;
   subTotalElement.textContent = '₹' + newSubTotal + '/-';

   // Update Grand Total
   let allSubTotals = document.querySelectorAll('.sub-total-price');
   let grandTotal = 0;
   allSubTotals.forEach(function(subTotal) {
      grandTotal += parseFloat(subTotal.textContent.replace('₹', '').replace('/-', ''));
   });
   document.getElementById('grand-total').textContent = '₹' + grandTotal;

   // Optional: Send AJAX request to update quantity in the database
   let xhr = new XMLHttpRequest();
   xhr.open('POST', 'update_cart.php', true);
   xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
   xhr.send('cart_id=' + cartId + '&qty=' + quantity);
}
</script>

</body>
</html>
