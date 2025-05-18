<footer class="site-footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 mb-4 mb-lg-0">
        <h5 class="text-uppercase">Custom Print</h5>
        <p class="text-muted">We provide high-quality personalized products for every occasion. Express yourself with our custom printing services.</p>
        <div class="social-icons mt-4">
          <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
          <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-pinterest"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
        <h5>Shop</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="{{ route('product.index') }}">All Products</a></li>
          <li class="mb-2"><a href="#">New Arrivals</a></li>
          <li class="mb-2"><a href="#">Featured</a></li>
          <li class="mb-2"><a href="#">Discounts</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
        <h5>Support</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#">Contact Us</a></li>
          <li class="mb-2"><a href="#">FAQs</a></li>
          <li class="mb-2"><a href="#">Shipping</a></li>
          <li class="mb-2"><a href="#">Returns</a></li>
        </ul>
      </div>
      <div class="col-lg-4">
        <h5>Newsletter</h5>
        <p class="text-muted">Subscribe to receive updates, access to exclusive deals, and more.</p>
        <form class="mt-3">
          <div class="input-group">
            <input type="email" class="form-control" placeholder="Enter your email" aria-label="Enter your email" aria-describedby="subscribe-btn">
            <button class="btn btn-primary" type="button" id="subscribe-btn">Subscribe</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="footer-bottom text-center py-3 mt-4">
    <div class="container">
      <p class="mb-0">&copy; {{ date('Y') }} Custom Print. All rights reserved.</p>
    </div>
  </div>
</footer>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- Custom JavaScript -->
<script>
  // Initialize tooltips
  document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  });
</script>