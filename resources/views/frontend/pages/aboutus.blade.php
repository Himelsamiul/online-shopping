@extends('frontend.master')

@section('content')

<!-- Include Font Awesome (if not already included in master layout) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  .about-section {
    background: linear-gradient(135deg, #f1f8ff, #e3f2fd);
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0, 123, 255, 0.1);
    transition: all 0.4s ease-in-out;
  }

  .about-section:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 25px rgba(0, 123, 255, 0.2);
  }

  .about-icon {
    font-size: 1.6rem;
    margin-right: 10px;
    transition: transform 0.3s;
  }

  .about-text:hover .about-icon {
    transform: rotate(360deg);
  }

  .about-image-container {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(33, 37, 41, 0.2);
    transition: transform 0.3s, box-shadow 0.3s;
  }

  .about-image-container:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
  }

  .about-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .about-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 123, 255, 0.3);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
  }

  .about-image-container:hover .about-overlay {
    opacity: 1;
  }

  .header-title {
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
  }

  .sub-header {
    font-size: 1.2rem;
    color: #5f6368;
  }

  .about-text p {
    font-size: 1.1rem;
    line-height: 1.6;
    color: #555;
  }

  .about-text i {
    color: #007bff;
  }
</style>

<div class="container py-5">
  <div class="text-center mb-5">
    <h2 class="header-title"><i class="fas fa-store text-primary me-2"></i>About Our Products</h2>
    <hr class="w-25 mx-auto">
    <p class="sub-header">Discover how we bring quality and care to your shopping experience.</p>
  </div>

  <div class="row align-items-center about-section">
    <!-- Image Box -->
    <div class="col-md-6 mb-4 mb-md-0">
      <div class="about-image-container">
        <img src="pro.jpeg" alt="Our Products" class="about-image">
        <div class="about-overlay">
          <h3>Explore Quality Products</h3>
        </div>
      </div>
    </div>
    
    <!-- Information Text -->
    <div class="col-md-6">
      <div class="about-text mb-4">
        <p class="fs-5">
          <i class="fas fa-check-circle text-success about-icon"></i>
          Our eCommerce platform offers an extensive collection of quality products designed to make your life easier. From daily essentials to premium gadgets, we’ve got it all with a secure and seamless shopping experience.
        </p>
      </div>
      <div class="about-text mb-4">
        <p class="fs-5">
          <i class="fas fa-tags text-info about-icon"></i>
          All our products are sourced from trusted vendors. With top-rated categories like electronics, fashion, and home essentials, we ensure that every item is genuine and of the highest quality.
        </p>
      </div>
      <div class="about-text">
        <p class="fs-5">
          <i class="fas fa-headset text-warning about-icon"></i>
          Our customer support team is available 24/7 to guide you through your shopping journey. No question is too small for us, and we’re always here to help.
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Optional: Add AOS animation (Animate On Scroll) -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init();
</script>
@endsection
