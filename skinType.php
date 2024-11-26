<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Skin Type Guide for Beginners</title>
  <link rel="stylesheet" href="css/style.css"/>
  <link rel="shortcut icon" href="images/fav-icon.png"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    /* General Styles */
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #b5bdca;
      padding-top: 80px;
    }

    /* Header Styles */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      background-color: #f6cdea;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      width: 100%;
      transition: all 0.3s ease;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: 800;
      color: #333;
      text-transform: uppercase;
      text-decoration: none;
      display: flex;
      align-items: center;
      margin-right: auto;
    }

    .navbar {
      display: flex;
      align-items: center;
      justify-content: center;
      flex: 1;
    }

    .navbar ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: space-around;
    }

    .navbar a {
      margin: 0 15px;
      font-size: 1rem;
      color: #555;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .navbar a:hover {
      color: #e91e63;
    }

    /* Skin Type Selection Styles */
    .container {
      width: 85%;
      margin: 0 auto;
      padding: 50px 0;
    }

    header {
      text-align: center;
      margin-bottom: 40px;
    }

    h1 {
      font-size: 50px;
      color: #5f6368;
    }

    .intro {
      font-size: 18px;
      color: #777;
      margin-bottom: 40px;
    }

    .skin-type-selection {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-bottom: 40px;
    }

    .skin-type-card {
      background-color: white;
      padding: 20px;
      text-align: center;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .skin-type-card:hover {
      transform: scale(1.05);
    }

    .skin-type-card img {
      width: 100%;
      height: auto;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .skin-type-card h3 {
      color: #5f6368;
      font-size: 20px;
      margin-bottom: 10px;
    }

    .skin-type-card p {
      color: #777;
      font-size: 14px;
    }

    /* Skincare Routine Styles */
    .skincare-routine {
      background-color: #ffffff;
      padding: 40px;
      margin-top: 60px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .skincare-routine h2 {
      font-size: 32px;
      color: #5f6368;
      text-align: center;
      margin-bottom: 30px;
    }

    .step {
      margin-bottom: 20px;
    }

    .step h3 {
      color: #333;
      font-size: 22px;
    }

    .step p {
      font-size: 16px;
      color: #777;
    }

    /* Customer Reviews Section Styles */
    .customer-reviews {
      background-color: #ffffff;
      padding: 40px;
      margin-top: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .customer-reviews h2 {
      font-size: 32px;
      color: #5f6368;
      text-align: center;
      margin-bottom: 30px;
    }

    .review {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    .review img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      margin-right: 15px;
    }

    .review-content {
      background-color: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .review-content p {
      margin: 0;
      color: #555;
    }

    .review-content .review-author {
      font-weight: 600;
      margin-top: 5px;
      color: #333;
    }
  </style>
</head>
<body>

  <!-- Header Section -->
  <section id="header" class="header">
  <a href="logo.png" class="logo">Face Skin Nova</a>
    <nav class="navbar">
      <ul>
        <a href="index.html">Home</a>
        <a href="userProducts.php">Product</a>
        <a href="skinType.php">Skin Type</a>
        <a href="reviews.php">Customer Experience</a>
        <a href="videoTutorial.html">Video Tutorial</a>
        <a href="customerMessages.php">Customer Support</a>
        <a href="adminLogin.php">Admin</a>
      </ul>
    </nav>
  </section>

  <div class="container">
    <header>
      <h1>Skin Type Guide for Beginners</h1>
      <p class="intro">Knowing your skin type is essential for choosing the right skincare products. Let's figure out what works best for you!</p>
    </header>

    <!-- Skin Type Selection -->
    <section class="skin-type-selection">
      <div class="skin-type-card" onclick="displaySkinTypeInfo('normal')">
        <img src="normal.jpg" alt="Normal Skin">
        <h3>Normal Skin</h3>
        <p>Balanced, healthy-looking skin.</p>
      </div>
      <div class="skin-type-card" onclick="displaySkinTypeInfo('dry')">
        <img src="dry.jpg" alt="Dry Skin">
        <h3>Dry Skin</h3>
        <p>Skin feels tight, flaky, or rough.</p>
      </div>
      <div class="skin-type-card" onclick="displaySkinTypeInfo('oily')">
        <img src="oily.jpg" alt="Oily Skin">
        <h3>Oily Skin</h3>
        <p>Excess shine, especially in the T-zone.</p>
      </div>
      <div class="skin-type-card" onclick="displaySkinTypeInfo('combination')">
        <img src="combination.jpg" alt="Combination Skin">
        <h3>Combination Skin</h3>
        <p>Mix of oily and dry areas.</p>
      </div>
    </section>

    <!-- Skincare Routine for Beginners -->
    <section class="skincare-routine">
      <h2>Step-by-Step Skincare Routine for Beginners</h2>
      <div class="step">
        <h3>Step 1: Cleansing</h3>
        <p>Use a gentle cleanser to remove dirt, oil, and impurities. Cleanse your face twice daily: once in the morning and once before bed.</p>
      </div>
      <div class="step">
        <h3>Step 2: Serum</h3>
        <p>Serums contain concentrated ingredients targeting specific skin concerns. Use a serum after toning, once or twice a day depending on your product’s instructions.</p>
      </div>
      <div class="step">
        <h3>Step 3: Moisturizing</h3>
        <p>Choose a moisturizer suited to your skin type. Apply moisturizer twice a day morning and night to keep skin hydrated and protected.</p>
      </div>
      <div class="step">
        <h3>Step 4: Sunscreen</h3>
        <p>Apply sunscreen every morning to protect your skin from harmful UV rays. Use SPF 30 or higher, and reapply every 2 hours if you're outdoors.</p>
      </div>
    </section>

  </div>

  <script>
    function displaySkinTypeInfo(type) {
      alert('Displaying information for ' + type + ' skin.');
    }
  </script>

</body>
</html>
