window.addEventListener('beforeprint', () => {
  const printModal = document.querySelector('.clipit-print-modal');
  printModal.hidden = false;
});
window.addEventListener('afterprint', () => {
  const printModal = document.querySelector('.clipit-print-modal');
  printModal.hidden = true;
});
