<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About Us</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

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
   <h3>About Us</h3>
   <p><a href="home.php">Home</a> <span> / About Us</span></p>
</div>

<!-- About Section Starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="About Our Restaurant">
      </div>

      <div class="content">
         <h3>Why Choose Us?</h3>
         <p>At our restaurant, we believe that dining is not just about eating food—it's about experiencing moments that linger. We use only the freshest, highest-quality ingredients, sourced locally whenever possible, to bring you dishes that are both delicious and authentic. Our chefs are passionate about every detail, ensuring that each dish tells a story of flavor and craftsmanship.</p>
         <p>From the warm ambiance to the exceptional service, our goal is to make every guest feel at home. Whether you're here for a family celebration, a romantic dinner, or just a quick bite, we want to create memories that bring you back again and again. Experience our carefully curated menu, crafted with love and inspired by both tradition and innovation, to discover a culinary journey like no other.</p>
         <a href="menu.php" class="btn">Explore Our Menu</a>
      </div>

   </div>

</section>

<!-- About Section Ends -->

<!-- Steps Section Starts  -->

<section class="steps">

   <h1 class="title">How It Works</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/step-1.png" alt="Choose Order">
         <h3>Choose Your Order</h3>
         <p>Explore our extensive menu filled with flavorful options. Whether it's your favorite classic or something new, selecting your dish is the first step towards a delightful experience.</p>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="Fast Delivery">
         <h3>Fast & Fresh Delivery</h3>
         <p>We take pride in delivering your food quickly and at the perfect temperature. Our efficient delivery team ensures that every meal reaches you fresh and ready to enjoy.</p>
      </div>

      <div class="box">
         <img src="images/step-3.png" alt="Enjoy Food">
         <h3>Enjoy Your Meal</h3>
         <p>Take a moment to savor the taste of our carefully prepared dishes. Whether you're dining in or at home, our meals are designed to bring joy to every bite.</p>
      </div>

   </div>

</section>

<!-- Steps Section Ends -->

<!-- Reviews Section Starts  -->

<section class="reviews">

   <h1 class="title">Customer Reviews</h1>

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <img src="images/anaghasree.jpg" alt="Customer Review">
            <p>The food here is absolutely amazing! The flavors are authentic, and the service is always top-notch. We love coming here for family dinners—it's become our favorite spot in town!</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Anagha </h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/achuth.jpg" alt="Customer Review">
            <p>From the ambiance to the quality of the dishes, everything was perfect. You can tell that a lot of thought goes into every aspect of this restaurant. Highly recommended!</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
             <!--  <i class="fas fa-star"></i> -->
               <i class="fas fa-star"></i>
            </div>
            <h3>Achuth</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/avin.jpg" alt="Customer Review">
            <p>From the ambiance to the quality of the dishes, everything was perfect. You can tell that a lot of thought goes into every aspect of this restaurant. Highly recommended!</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
            </div>
            <h3>Avin</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/vinod.jpg" alt="Customer Review">
            <p>Wonderful experience! The staff was friendly, and the food was out of this world. We will definitely be back for more.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Vinod</h3>
         </div>

         

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<!-- Reviews Section Ends -->

<!-- Footer Section Starts  -->
<?php include 'components/footer.php'; ?>
<!-- Footer Section Ends -->

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- Custom JS File Link  -->
<script src="js/script.js"></script>

<script>
var swiper = new Swiper(".reviews-slider", {
   loop: true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
   },
   breakpoints: {
      0: {
         slidesPerView: 1,
      },
      700: {
         slidesPerView: 2,
      },
      1024: {
         slidesPerView: 3,
      },
   },
});
</script>

</body>
</html>
