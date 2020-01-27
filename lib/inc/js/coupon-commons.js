const printCoupon = () => {
  printJS({
    printable: 'clipit',
    type: 'html',
    style:
      '.clipit-coupons{--color-accent:#d40400;--color-title:#4285f4;display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));grid-gap:2em;font-size:16px;max-width:1100px;margin:0 auto}.clipit-coupons--single{display:block;padding:3em 0 5em}.clipit-coupon{position:relative;display:grid;grid-template-rows:auto auto 1fr auto auto auto;border:1px solid #ccc;padding:1em;border-radius:.5em;box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 1px 5px 0 rgba(0,0,0,.12),0 3px 1px -2px rgba(0,0,0,.2);background-color:#fff}.clipit-coupon--single{display:block;text-align:left;max-width:750px;margin:2em auto;box-shadow:none;border-style:dashed;border-width:3px}.clipit-coupon--single .clipit-coupon__act,.clipit-coupon--single .clipit-coupon__expiration,.clipit-coupon--single .clipit-coupon__subtitle,.clipit-coupon--single .clipit-coupon__title{text-align:left}.clipit-coupon--single .clipit-coupon__subtitle{display:block;margin-bottom:1em}.clipit-coupon--single .clipit-coupon__act,.clipit-coupon--single .clipit-coupon__expiration{display:inline-block}.clipit-coupon--single .clipit-coupon__expiration{margin-right:.5em}.clipit-coupon__fine{display:grid;grid-template-columns:3fr 2fr;grid-gap:1em;width:100%;margin-top:1em;font-size:.85em}.clipit-coupon__fine img{max-height:100px}.clipit-coupon__icon{position:absolute;width:1.5em;top:-.95em;left:2em;height:1.5em;color:#ccc}.clipit-coupon__icon path{fill:currentColor}.clipit-coupon__save-wrapper{text-align:center;margin:-1em -1em 1em -1em}.clipit-coupon__save{font-family:Arvo,sans-serif;display:inline-block;background-color:var(--color-accent);color:#fff;font-size:2.5em;line-height:1;text-transform:uppercase;font-weight:700;padding:.25em 1em .75em;clip-path:polygon(0 0,100% 0,100% 100%,0 calc(100% - .75em),0 0)}.clipit-coupon__title{display:block;margin-bottom:.5em;color:var(--color-title);font-size:1.9375em;line-height:1.5em;text-align:center}.clipit-coupon__subtitle{font-size:1.375em;line-height:1.45em}.clipit-coupon__subtitle *{margin:0}.clipit-coupon__spacer{display:block;min-height:1em}.clipit-coupon__act,.clipit-coupon__expiration{white-space:nowrap;display:block;text-align:center}.clipit-coupon__act{font-weight:600;font-style:italic}.clipit-coupon__button{visibility:hidden}.clipit-schedule-title{text-align:center;margin:2em 0 1em;text-transform:uppercase;font-size:2em}',
  });
};

document
  .querySelector('.clipit-coupon__button--print')
  .addEventListener('click', e => {
    e.preventDefault();
    printCoupon();
  });

const Printer = (function() {
  const d = document;
  let html = '';
  function print() {
    html = d.querySelector('body').innerHTML;
    const coupon = d.querySelector('#clipit').innerHTML;
    d.querySelector('body').innerHTML = coupon;
  }
  function reset() {
    if (html) {
      d.querySelector('body').innerHTML = html;
    }
  }
  return {
    print: print,
    reset: reset,
  };
})();
window.addEventListener('beforeprint', e => {
  Printer.print();
});
window.addEventListener('afterprint', e => {
  Printer.reset();
});
