@extends('frontend.layouts.master')
@section('body-class', 'no-navbar-scroll')
@section('contents')
  <style>
    .page{
      padding-bottom: 66px;
      min-height:100vh;
    }

    .stepper{
      display:flex;
      flex-direction:column;
      align-items:center;
      margin:2rem 0 1.5rem;
      padding:0 1rem;
      gap:1rem;
      height:120px;
    }
    .stepper-image{
      max-width:400px;
      width:100%;
      height:auto;
      max-height:80px;
      object-fit:contain;
    }
    .stepper-labels{
      display:flex;
      justify-content:space-between;
      width:100%;
      max-width:400px;
    }
    .step-label{
      font-size:.95rem;
      color:var(--muted);
      letter-spacing:.5px;
      text-align:center;
      flex:1;
    }
    .step-label.active{
      color:var(--primary-blue);
      font-weight:700;
    }

    .container{
      max-width:1100px;
      margin:0 auto;
      padding:0 clamp(1rem, 3vw, 2rem);
    }

    .cart-list{
      display:flex;
      flex-direction:column;
      gap:1rem;
    }

    .cart-item{
      display:grid;
      grid-template-columns:84px 1fr auto;
      gap:14px;
      border:1px solid var(--border);
      padding:14px;
      background:#fafafa;
      border-radius:14px;
    }
    .cart-img{
      width:84px;height:84px;
      border-radius:12px;
      background:#eee;
      border:1px solid rgba(7,32,63,.10);
      overflow:hidden;
    }
    .cart-img img{
      width:100%;
      height:100%;
      object-fit:cover;
    }
    .cart-info h4{
      font-family:var(--font-primary);
      color:var(--primary-blue);
      font-size:1.1rem;
      font-weight:600;
      letter-spacing:.5px;
    }
    .price-container{
      margin:.35rem 0 .25rem;
      display:flex;
      align-items:center;
      gap:.5rem;
      flex-wrap:wrap;
    }
    .price{
      font-weight:800;
      color:var(--dark);
    }
    .original-price{
      font-size:.9rem;
      color:var(--muted);
      text-decoration:line-through;
    }
    .discount{
      font-size:.75rem;
      color:#27ae60;
      font-weight:700;
    }
    .product-code{
      font-size:.75rem;
      color:var(--muted);
      margin-top:.25rem;
    }
    .delivery-info{
      font-size:.8rem;
      color:var(--muted);
      margin-top:.25rem;
    }
    .qty{
      display:inline-flex;
      align-items:center;
      gap:10px;
      background:#fff;
      border:1px solid var(--border);
      padding:.35rem .5rem;
      border-radius:12px;
      width:max-content;
      margin-top:.5rem;
    }
    .qty button{
      width:28px;height:28px;
      border:1px solid rgba(7,32,63,.16);
      background:#fff;
      border-radius:10px;
      cursor:pointer;
      transition:.2s ease;
    }
    .qty button:hover{
      background:var(--primary-blue);
      color:#fff;
    }
    .qty span{min-width:18px;text-align:center;font-weight:700;color:var(--primary-blue)}

    .cart-actions{
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      align-items:flex-end;
      gap:.5rem;
    }
    .remove{
      font-size:.82rem;
      color:var(--muted);
      cursor:pointer;
      user-select:none;
    }
    .remove:hover{color:var(--primary-blue);text-decoration:underline}

    .coupon{
      margin-top:1rem;
      border:1px dashed rgba(7,32,63,.22);
      padding:.9rem 1rem;
      background:rgba(235,222,212,.7);
      text-align:center;
      font-size:.9rem;
      border-radius:14px;
      color:rgba(2,0,13,.75);
      cursor:pointer;
      transition:.2s ease;
    }
    .coupon:hover{
      background:rgba(235,222,212,.9);
    }

    .pickup{
      margin-top:1rem;
      border:1px solid var(--border);
      padding:.9rem 1rem;
      font-size:.9rem;
      border-radius:14px;
      background:#fff;
      color:rgba(2,0,13,.75);
      display:flex;
      align-items:center;
      gap:.75rem;
    }
    .pickup i{
      color:var(--primary-blue);
    }
    .pickup .tag{
      margin-left:auto;
      font-size:.75rem;
      color:var(--muted);
    }

    .usp{
      display:flex;
      justify-content:center;
      margin:1.5rem 0 0;
      font-size:.85rem;
      color:var(--muted);
      gap:2rem;
      flex-wrap:wrap;
    }
    .usp span{
      display:flex;align-items:center;gap:.5rem;
      border:1px solid rgba(7,32,63,.10);
      background:#fff;
      padding:.65rem .8rem;
      border-radius:999px;
    }
    .usp i{color:var(--primary-blue)}

    /* ================= ADD MORE ITEMS SECTION ================= */
    .add-more-section{
      margin-top:2.5rem;
      margin-bottom:2rem;
    }
    .add-more-title{
      font-family:var(--font-primary);
      font-size:1.4rem;
      font-weight:700;
      text-align:center;
      color:var(--primary-blue);
      margin-bottom:1.5rem;
      letter-spacing:.5px;
    }
    .product-grid{
      display:grid;
      grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));
      gap:1.25rem;
    }
    .product-card{
      border:1px solid var(--border);
      border-radius:14px;
      overflow:hidden;
      background:#fff;
      transition:.25s ease;
      cursor:pointer;
    }
    .product-card:hover{
      box-shadow:var(--shadow);
      transform:translateY(-4px);
    }
    .product-image{
      width:100%;
      aspect-ratio:1;
      background:#f5f5f5;
      border-bottom:1px solid var(--border);
    }
    .product-info{
      padding:1rem;
      text-align:center;
    }
    .product-name{
      font-family:var(--font-primary);
      font-size:1rem;
      font-weight:600;
      color:var(--primary-blue);
      margin-bottom:.5rem;
    }
    .product-price{
      font-weight:800;
      color:var(--dark);
      font-size:.95rem;
    }

    /* ================= STICKY FOOTER CTA ================= */
    .cart-footer{
      position:fixed;bottom:0;left:0;width:100%;
      background:rgba(255,255,255,.95);
      backdrop-filter:blur(8px);
      border-top:1px solid var(--border);
      padding:.75rem 1rem;
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap:1rem;
      z-index:9996;
      box-shadow:0 -4px 12px rgba(0,0,0,.06);
    }
    .total{
      font-weight:900;
      color:var(--primary-blue);
      letter-spacing:.2px;
    }
    .checkout{
      padding:.85rem 1.25rem;
      background:var(--primary-blue);
      color:#fff;
      border:none;
      border-radius:12px;
      text-transform:uppercase;
      letter-spacing:1.2px;
      font-size:.85rem;
      cursor:pointer;
      transition:.25s ease;
      white-space:nowrap;
    }
    .checkout:hover{
      background:#050f21;
      transform:scale(1.02);
    }

    /* ================= TOAST NOTIFICATION ================= */
    .toast{
      position:fixed;
      bottom:100px;
      right:20px;
      background:var(--primary-blue);
      color:#fff;
      padding:1rem 1.5rem;
      border-radius:12px;
      box-shadow:0 4px 12px rgba(0,0,0,.15);
      display:flex;
      align-items:center;
      gap:.75rem;
      opacity:0;
      transform:translateY(20px);
      transition:all .3s ease;
      z-index:10000;
      max-width:350px;
      font-size:.9rem;
    }
    .toast.show{
      opacity:1;
      transform:translateY(0);
    }
    .toast i{
      font-size:1.2rem;
    }
    .toast.success{
      background:#27ae60;
    }
    .toast.error{
      background:#e74c3c;
    }
    .toast.info{
      background:#3498db;
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 768px){
      .nav-container{
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:.9rem 1.25rem;
      }
      .hamburger{display:flex;width:44px}
      .nav-left{display:none}
      .nav-right{gap:1rem;width:86px;justify-content:flex-end}
      .nav-center{
        position:absolute;
        left:50%;
        transform:translateX(-50%);
      }
      .nav-logo img{height:54px}
      .nav-links-container{display:none}
      
      .product-grid{
        grid-template-columns:repeat(2, 1fr);
      }

      .usp{
        gap:1rem;
      }
      
      .stepper{
        height:100px;
      }
      .stepper-image{
        max-width:300px;
        max-height:65px;
      }
      .step-label{
        font-size:.85rem;
      }
    }

    @media (max-width: 560px){
      .stepper{
        height:90px;
      }
      .stepper-image{
        max-width:280px;
        max-height:55px;
      }
      .step-label{
        font-size:.8rem;
      }
      .cart-item{
        grid-template-columns:72px 1fr;
        grid-template-areas:
          "img info"
          "actions actions";
      }
      .cart-img{grid-area:img;width:72px;height:72px}
      .cart-info{grid-area:info}
      .cart-actions{
        grid-area:actions;
        flex-direction:row;
        align-items:center;
        justify-content:space-between;
        border-top:1px solid rgba(7,32,63,.10);
        padding-top:.75rem;
        margin-top:.5rem;
      }
      .checkout{padding:.85rem 1rem}
      
      .toast{
        left:10px;
        right:10px;
        max-width:calc(100% - 20px);
        bottom:90px;
      }
    }
  </style>
<body>
  <main class="page">
    <div class="container">
      <!-- STEPS -->
      <div class="stepper">
        <img src="./assets/23.png" alt="Order Progress" class="stepper-image" />
        <div class="stepper-labels">
          <span class="step-label active">Bag</span>
          <span class="step-label">Order Details</span>
          <span class="step-label">Payment</span>
        </div>
      </div>

      <!-- CART ITEMS -->
      <section class="cart-list" aria-label="Cart items">
        <div class="cart-item">
          <div class="cart-img" aria-hidden="true">
            <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=300&h=300&fit=crop" alt="Elegant Silver Ring" />
          </div>
          <div class="cart-info">
            <h4>Elegant Silver Ring</h4>
            <div class="price-container">
              <span class="price">₹24,999</span>
              <span class="original-price">₹29,999</span>
              <span class="discount">(17% OFF)</span>
            </div>
            <div class="product-code">Product Code: ESR-2024-001</div>
            <div class="delivery-info">Delivery by 2047</div>
            <div class="qty" aria-label="Quantity selector">
              <button type="button" aria-label="Decrease quantity">-</button>
              <span>1</span>
              <button type="button" aria-label="Increase quantity">+</button>
            </div>
          </div>
          <div class="cart-actions">
            <span class="remove" role="button" tabindex="0">Remove</span>
          </div>
        </div>

        <div class="cart-item">
          <div class="cart-img" aria-hidden="true">
            <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=300&h=300&fit=crop" alt="Drop Earrings" />
          </div>
          <div class="cart-info">
            <h4>Drop Earrings</h4>
            <div class="price-container">
              <span class="price">₹12,999</span>
              <span class="original-price">₹15,999</span>
              <span class="discount">(19% OFF)</span>
            </div>
            <div class="product-code">Product Code: DE-2024-045</div>
            <div class="delivery-info">Delivery by 2047</div>
            <div class="qty" aria-label="Quantity selector">
              <button type="button" aria-label="Decrease quantity">-</button>
              <span>1</span>
              <button type="button" aria-label="Increase quantity">+</button>
            </div>
          </div>
          <div class="cart-actions">
            <span class="remove" role="button" tabindex="0">Remove</span>
          </div>
        </div>
      </section>

      <!-- COUPON -->
      <div class="coupon">
        <i class="fas fa-ticket-alt"></i>
        Apply Coupon • View all offers
      </div>

      <!-- PICKUP -->
      <div class="pickup">
        <i class="fas fa-store"></i>
        <span>Pick up from store</span>
        <span class="tag">only for Kolkata's pincode</span>
      </div>

      <!-- USP -->
      <div class="usp">
        <span><i class="fa-solid fa-lock"></i> Secure Payment</span>
        <span><i class="fa-solid fa-rotate-left"></i> Easy Exchange</span>
      </div>

      <!-- ADD MORE ITEMS SECTION -->
      <section class="add-more-section">
        <h3 class="add-more-title">ADD MORE ITEMS</h3>
        <div class="product-grid">
          <div class="product-card">
            <div class="product-image">
              <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=400&h=400&fit=crop" alt="Gold Necklace" style="width:100%;height:100%;object-fit:cover;" />
            </div>
            <div class="product-info">
              <div class="product-name">Gold Necklace</div>
              <div class="product-price">₹34,999</div>
            </div>
          </div>
          <div class="product-card">
            <div class="product-image">
              <img src="https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=400&h=400&fit=crop" alt="Diamond Bracelet" style="width:100%;height:100%;object-fit:cover;" />
            </div>
            <div class="product-info">
              <div class="product-name">Diamond Bracelet</div>
              <div class="product-price">₹45,999</div>
            </div>
          </div>
          <div class="product-card">
            <div class="product-image">
              <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=400&h=400&fit=crop" alt="Pearl Earrings" style="width:100%;height:100%;object-fit:cover;" />
            </div>
            <div class="product-info">
              <div class="product-name">Pearl Earrings</div>
              <div class="product-price">₹18,999</div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <!-- STICKY FOOTER -->
  <div class="cart-footer" role="region" aria-label="Cart total and checkout">
    <div class="total">Total: ₹37,998</div>
    <button class="checkout" type="button">Proceed</button>
  </div>

  <!-- TOAST NOTIFICATION -->
  <div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <span id="toast-message"></span>
  </div>

  <script>

    // ============================================================
    // CART FUNCTIONALITY
    // ============================================================
    
    // Toast notification function
    function showToast(message, type = 'success') {
      const toast = document.getElementById('toast');
      const toastMessage = document.getElementById('toast-message');
      const toastIcon = toast.querySelector('i');
      
      // Set message
      toastMessage.textContent = message;
      
      // Set icon and type
      toast.className = 'toast';
      if (type === 'success') {
        toast.classList.add('success');
        toastIcon.className = 'fas fa-check-circle';
      } else if (type === 'error') {
        toast.classList.add('error');
        toastIcon.className = 'fas fa-exclamation-circle';
      } else if (type === 'info') {
        toast.classList.add('info');
        toastIcon.className = 'fas fa-info-circle';
      }
      
      // Show toast
      toast.classList.add('show');
      
      // Hide after 3 seconds
      setTimeout(() => {
        toast.classList.remove('show');
      }, 3000);
    }
    
    // Cart data structure
    let cartItems = [
      { 
        id: 1, 
        name: "Elegant Silver Ring", 
        price: 24999, 
        originalPrice: 29999,
        productCode: "ESR-2024-001",
        quantity: 1, 
        image: "https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=300&h=300&fit=crop" 
      },
      { 
        id: 2, 
        name: "Drop Earrings", 
        price: 12999, 
        originalPrice: 15999,
        productCode: "DE-2024-045",
        quantity: 1, 
        image: "https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=300&h=300&fit=crop" 
      }
    ];

    // Update cart total
    function updateCartTotal() {
      const total = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
      document.querySelector('.total').textContent = `Total: ₹${total.toLocaleString('en-IN')}`;
    }

    // Quantity buttons functionality
    document.addEventListener('click', (e) => {
      // Handle quantity increase
      if (e.target.matches('.qty button[aria-label="Increase quantity"]')) {
        const cartItem = e.target.closest('.cart-item');
        const index = Array.from(document.querySelectorAll('.cart-item')).indexOf(cartItem);
        const qtySpan = cartItem.querySelector('.qty span');
        
        cartItems[index].quantity++;
        qtySpan.textContent = cartItems[index].quantity;
        updateCartTotal();
        
        // Add visual feedback
        qtySpan.style.transform = 'scale(1.2)';
        setTimeout(() => qtySpan.style.transform = 'scale(1)', 200);
        
        // Show toast
        showToast('Quantity updated', 'success');
      }

      // Handle quantity decrease
      if (e.target.matches('.qty button[aria-label="Decrease quantity"]')) {
        const cartItem = e.target.closest('.cart-item');
        const index = Array.from(document.querySelectorAll('.cart-item')).indexOf(cartItem);
        const qtySpan = cartItem.querySelector('.qty span');
        
        if (cartItems[index].quantity > 1) {
          cartItems[index].quantity--;
          qtySpan.textContent = cartItems[index].quantity;
          updateCartTotal();
          
          // Add visual feedback
          qtySpan.style.transform = 'scale(0.8)';
          setTimeout(() => qtySpan.style.transform = 'scale(1)', 200);
          
          // Show toast
          showToast('Quantity updated', 'success');
        }
      }

      // Handle remove button
      if (e.target.matches('.remove')) {
        const cartItem = e.target.closest('.cart-item');
        const index = Array.from(document.querySelectorAll('.cart-item')).indexOf(cartItem);
        const itemName = cartItems[index].name;
        
        // Fade out animation
        cartItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        cartItem.style.opacity = '0';
        cartItem.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
          cartItems.splice(index, 1);
          cartItem.remove();
          updateCartTotal();
          
          // Show toast
          showToast(`${itemName} removed from cart`, 'info');
          
          // Check if cart is empty
          if (cartItems.length === 0) {
            document.querySelector('.cart-list').innerHTML = `
              <div style="text-align:center;padding:3rem 1rem;color:var(--muted);">
                <i class="fas fa-shopping-bag" style="font-size:3rem;margin-bottom:1rem;opacity:0.3;"></i>
                <p style="font-size:1.1rem;">Your cart is empty</p>
                <p style="font-size:0.9rem;margin-top:0.5rem;">Add some beautiful jewelry to get started!</p>
              </div>
            `;
            document.querySelector('.checkout').disabled = true;
            document.querySelector('.checkout').style.opacity = '0.5';
            document.querySelector('.checkout').style.cursor = 'not-allowed';
          }
        }, 300);
      }

      // Handle checkout button
      if (e.target.matches('.checkout')) {
        if (cartItems.length > 0) {
          showToast('Proceeding to order details...', 'success');
          // In a real app: setTimeout(() => window.location.href = '/checkout', 1000);
        }
      }

      // Handle coupon section
      if (e.target.matches('.coupon') || e.target.closest('.coupon')) {
        showToast('Coupon feature coming soon!', 'info');
        // In a real app: open coupon modal
      }

      // Handle product cards in "Add More Items"
      if (e.target.closest('.product-card')) {
        const card = e.target.closest('.product-card');
        const productName = card.querySelector('.product-name').textContent;
        const productPrice = card.querySelector('.product-price').textContent;
        const productImage = card.querySelector('.product-image img').src;
        
        // Parse price (remove ₹ and commas)
        const price = parseInt(productPrice.replace(/[₹,]/g, ''));
        
        // Generate product code
        const productCode = productName.toUpperCase().replace(/\s+/g, '-').substring(0, 10) + '-' + Math.floor(Math.random() * 1000);
        
        // Check if item already exists in cart
        const existingItemIndex = cartItems.findIndex(item => item.name === productName);
        
        if (existingItemIndex !== -1) {
          // Item exists, increase quantity
          cartItems[existingItemIndex].quantity++;
          
          // Update the quantity display in the cart
          const cartItemElements = document.querySelectorAll('.cart-item');
          if (cartItemElements[existingItemIndex]) {
            const qtySpan = cartItemElements[existingItemIndex].querySelector('.qty span');
            qtySpan.textContent = cartItems[existingItemIndex].quantity;
            
            // Visual feedback
            qtySpan.style.transform = 'scale(1.3)';
            setTimeout(() => qtySpan.style.transform = 'scale(1)', 300);
          }
          
          showToast(`${productName} quantity increased!`, 'success');
        } else {
          // New item, add to cart
          const newItem = {
            id: cartItems.length + 1,
            name: productName,
            price: price,
            originalPrice: Math.floor(price * 1.2), // 20% markup for original price
            productCode: productCode,
            quantity: 1,
            image: productImage
          };
          
          cartItems.push(newItem);
          
          // Create and add new cart item HTML
          const cartList = document.querySelector('.cart-list');
          const discount = Math.round(((newItem.originalPrice - newItem.price) / newItem.originalPrice) * 100);
          
          const newCartItemHTML = `
            <div class="cart-item" style="opacity:0;transform:translateY(20px);">
              <div class="cart-img" aria-hidden="true">
                <img src="${newItem.image}" alt="${newItem.name}" />
              </div>
              <div class="cart-info">
                <h4>${newItem.name}</h4>
                <div class="price-container">
                  <span class="price">₹${newItem.price.toLocaleString('en-IN')}</span>
                  <span class="original-price">₹${newItem.originalPrice.toLocaleString('en-IN')}</span>
                  <span class="discount">(${discount}% OFF)</span>
                </div>
                <div class="product-code">Product Code: ${newItem.productCode}</div>
                <div class="delivery-info">Delivery by 2047</div>
                <div class="qty" aria-label="Quantity selector">
                  <button type="button" aria-label="Decrease quantity">-</button>
                  <span>1</span>
                  <button type="button" aria-label="Increase quantity">+</button>
                </div>
              </div>
              <div class="cart-actions">
                <span class="remove" role="button" tabindex="0">Remove</span>
              </div>
            </div>
          `;
          
          cartList.insertAdjacentHTML('beforeend', newCartItemHTML);
          
          // Animate the new item in
          const newCartItem = cartList.lastElementChild;
          setTimeout(() => {
            newCartItem.style.transition = 'all 0.3s ease';
            newCartItem.style.opacity = '1';
            newCartItem.style.transform = 'translateY(0)';
          }, 10);
          
          showToast(`${productName} added to cart!`, 'success');
        }
        
        // Update total
        updateCartTotal();
        
        // Add pulse animation to card
        card.style.animation = 'pulse 0.3s ease';
        setTimeout(() => card.style.animation = '', 300);
      }
    });

    // Add CSS animation for pulse effect
    const style = document.createElement('style');
    style.textContent = `
      @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(0.95); }
      }
      .qty span {
        transition: transform 0.2s ease;
      }
    `;
    document.head.appendChild(style);

    // Initialize total on page load
    updateCartTotal();
  </script>
@endsection