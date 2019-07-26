window.addEventListener('beforeprint', () => {
  const printModal = document.querySelector('.clipit-print-modal');
  printModal.appendChild(document.querySelector('.clipit-coupon'));
  printModal.hidden = false;
});
window.addEventListener('afterprint', () => {
  const printModal = document.querySelector('.clipit-print-modal');
  const clipitDiv = document.querySelector('.clipit-coupons');
  const clipitButton = document.querySelector('.clipit-coupon__button');
  clipitDiv.insertBefore(printModal.querySelector('.clipit-coupon'), clipitButton);
  printModal.hidden = true;
});
