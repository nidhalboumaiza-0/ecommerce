document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggers = document.querySelectorAll('[data-tooltip]');
    tooltipTriggers.forEach(el => {
      el.addEventListener('mouseenter', showTooltip);
      el.addEventListener('mouseleave', hideTooltip);
    });
  
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuBtn && mobileMenu) {
      mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
    }
  });
  
  function showTooltip(e) {
    const tooltipText = this.getAttribute('data-tooltip');
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = tooltipText;
    document.body.appendChild(tooltip);
  
    const rect = this.getBoundingClientRect();
    tooltip.style.top = `${rect.top - tooltip.offsetHeight - 10}px`;
    tooltip.style.left = `${rect.left + rect.width / 2 - tooltip.offsetWidth / 2}px`;
  }
  
  function hideTooltip() {
    const tooltip = document.querySelector('.tooltip');
    if (tooltip) {
      tooltip.remove();
    }
  }
  
  // Form Validation Functions
  function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;
  
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
  
    requiredFields.forEach(field => {
      if (!field.value.trim()) {
        field.classList.add('error');
        isValid = false;
      } else {
        field.classList.remove('error');
      }
    });
  
    // Specific validations based on form ID
    if (formId === 'signup-form' || formId === 'password-form') {
      const password = form.querySelector('#password');
      const confirmPassword = form.querySelector('#confirm_password');
      
      if (password && confirmPassword && password.value !== confirmPassword.value) {
        confirmPassword.classList.add('error');
        alert('Passwords do not match');
        isValid = false;
      }
      
      if (password && password.value.length < 8) {
        password.classList.add('error');
        alert('Password must be at least 8 characters');
        isValid = false;
      }
    }
  
    if (formId === 'email-form') {
      const email = form.querySelector('#email');
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      
      if (email && !emailRegex.test(email.value)) {
        email.classList.add('error');
        alert('Please enter a valid email address');
        isValid = false;
      }
    }
  
    return isValid;
  }
  
  // Add to cart functionality
  function addToCart(productId, quantity = 1) {
    fetch('/api/cart', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ productId, quantity })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showNotification('Product added to cart', 'success');
        updateCartCount(data.cartCount);
      } else {
        showNotification(data.message || 'Error adding to cart', 'error');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification('Network error', 'error');
    });
  }
  
  function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);
  
    setTimeout(() => {
      notification.classList.add('fade-out');
      setTimeout(() => notification.remove(), 300);
    }, 3000);
  }
  
  function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(el => {
      el.textContent = count;
      el.style.display = count > 0 ? 'inline-block' : 'none';
    });
  }
  // Vehicle Selector (placeholder)
const makes = ['Toyota', 'Honda', 'Ford'];
document.getElementById('make').innerHTML += makes.map(make => `<option value="${make}">${make}</option>`).join('');

// Countdown (placeholder)
function updateCountdown() {
  let hours = 12, minutes = 45, seconds = 30;
  setInterval(() => {
    seconds--;
    if (seconds < 0) { seconds = 59; minutes--; }
    if (minutes < 0) { minutes = 59; hours--; }
    document.getElementById('countdown-hours').textContent = hours;
    document.getElementById('countdown-minutes').textContent = minutes;
    document.getElementById('countdown-seconds').textContent = seconds;
  }, 1000);
}
updateCountdown();

// Product Tabs (placeholder)
document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelector('.tab-btn.active').classList.remove('active');
    btn.classList.add('active');
    // AJAX call to load products
    console.log('Load products for:', btn.dataset.category);
  });
});
function addToCart(productId, quantity) {
  console.log(`Added product ${productId} with quantity ${quantity}`);
  // Implement cart logic (e.g., AJAX to add to cart)
}

document.getElementById('searchBtn').addEventListener('click', () => {
  const query = document.getElementById('searchInput').value;
  console.log('Search:', query);
  // Implement search logic (e.g., redirect to search page)
});

document.getElementById('sort').addEventListener('change', (e) => {
  console.log('Sort by:', e.target.value);
  // Implement sort logic (e.g., reload page with sort parameter)
});

document.querySelectorAll('.quick-view').forEach(btn => {
  btn.addEventListener('click', () => {
    const productId = btn.dataset.id;
    console.log('Quick view product:', productId);
    // Implement quick view logic (e.g., modal popup)
  });
});