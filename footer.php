<footer style="background:#0078A0; color:#fff; padding:50px 20px; font-family: 'Arial', sans-serif;">
  <div style="max-width:1200px; margin:0 auto; display:flex; flex-wrap:wrap; justify-content:space-between; gap:20px;">
    
    <!-- Customer Care -->
    <div style="flex:1; min-width:200px; background:#0095C2; padding:20px; border-radius:8px;">
      <h3 style="margin-bottom:15px; font-size:1.3em;">Customer Care</h3>
      <ul style="list-style:none; padding:0; margin-top:10px; line-height:2;">
        <li><i class="fas fa-question-circle" style="margin-right:8px;"></i><a href="#" style="color:#fff; text-decoration:none; transition:0.3s;">FAQ</a></li>
        <li><i class="fas fa-shipping-fast" style="margin-right:8px;"></i><a href="#" style="color:#fff; text-decoration:none; transition:0.3s;">Shipping & Returns</a></li>
        <li><i class="fas fa-headset" style="margin-right:8px;"></i><a href="#" style="color:#fff; text-decoration:none; transition:0.3s;">Support</a></li>
      </ul>
    </div>

    <!-- About -->
    <div style="flex:1; min-width:200px; background:#0095C2; padding:20px; border-radius:8px;">
      <h3 style="margin-bottom:15px; font-size:1.3em;">About</h3>
      <ul style="list-style:none; padding:0; margin-top:10px; line-height:2;">
        <li><i class="fas fa-info-circle" style="margin-right:8px;"></i><a href="#" style="color:#fff; text-decoration:none; transition:0.3s;">Our Story</a></li>
        <li><i class="fas fa-briefcase" style="margin-right:8px;"></i><a href="#" style="color:#fff; text-decoration:none; transition:0.3s;">Careers</a></li>
        <li><i class="fas fa-user-shield" style="margin-right:8px;"></i><a href="#" style="color:#fff; text-decoration:none; transition:0.3s;">Privacy Policy</a></li>
      </ul>
    </div>

    <!-- Contact -->
    <div style="flex:1; min-width:200px; background:#0095C2; padding:20px; border-radius:8px;">
      <h3 style="margin-bottom:15px; font-size:1.3em;">Contact</h3>
      <ul style="list-style:none; padding:0; margin-top:10px; line-height:2;">
        <li><i class="fas fa-envelope" style="margin-right:8px;"></i>Email: support@athletic_park.com</li>
        <li><i class="fas fa-phone" style="margin-right:8px;"></i>Phone: +880 1787962708</li>
        <li><i class="fas fa-map-marker-alt" style="margin-right:8px;"></i>Address: Dhaka, Bangladesh</li>
      </ul>
    </div>

  </div>

  <!-- Copyright -->
  <div style="text-align:center; margin-top:40px; font-size:14px; color:#e0e0e0;">
    &copy; <?php echo date('Y'); ?> Athletic Park. All rights reserved.
  </div>
</footer>

<script>
let slides = document.querySelectorAll('.slider-container img');
let current = 0;
setInterval(() => {
  slides[current].classList.remove('active');
  current = (current + 1) % slides.length;
  slides[current].classList.add('active');
}, 3000);
</script>
</body>
</html>
