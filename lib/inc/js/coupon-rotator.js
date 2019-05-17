(function(d) {
  function initCouponRotators() {
    const parentNodes = d.querySelectorAll('[data-coupon-rotator]');
    parentNodes.forEach(parentNode => {
      new CouponRotator(parentNode.dataset.apiUrl, parentNode);
    });
  }

  addEventListener('DOMContentLoaded', initCouponRotators);
})(document);

class CouponRotator {
  apiUrl;
  parentNode;
  couponNodes;
  couponTag;
  currentIndex = 0;
  running = false;

  constructor(apiUrl, parentNode) {
    this.apiUrl = apiUrl;
    this.parentNode = parentNode;
    this.couponTag = parentNode.dataset.couponRotator;
    this.parentNode.classList.add('clipit-rotator');
    this.loadCoupons().then(() => {
      if (this.couponNodes.length < 1) {
        return;
      }
      this.couponNodes[0].style.opacity = 1;
      this.start();
    });
    this.parentNode.addEventListener('mouseover', () => {
      this.stop();
    });
    this.parentNode.addEventListener('mouseout', () => {
      this.start();
    });
    window.addEventListener('focus', () => {
      if (!this.interval) {
        this.start();
      }
    });
    window.addEventListener('blur', () => {
      this.stop();
    });
  }

  start() {
    this.interval = setInterval(() => {
      this.next();
    }, 3000);
  }

  stop() {
    clearInterval(this.interval);
    this.interval = null;
  }

  next() {
    this.couponNodes[this.currentIndex].style.opacity = 0;
    if (this.currentIndex < this.couponNodes.length - 1) {
      this.currentIndex++;
    } else {
      this.currentIndex = 0;
    }
    this.couponNodes[this.currentIndex].style.opacity = 1;
  }

  previous() {
    this.couponNodes[this.currentIndex].style.opacity = 0;
    if (this.currentIndex > 0) {
      this.currentIndex--;
    } else {
      this.currentIndex = this.couponNodes.length - 1;
    }
    this.couponNodes[this.currentIndex].style.opacity = 1;
  }

  filterExpiredCoupons(coupons) {
    return coupons.filter(coupon => {
      const { coupon_expiration: couponExpiration } = coupon.meta;
      const expirationDate = new Date(couponExpiration);
      const currentDate = new Date();
      if (expirationDate >= currentDate) {
        return coupon;
      }
    });
  }

  async fetchCoupons() {
    const request = await fetch(`${this.apiUrl}?tags=${this.couponTag}`);
    const json = await request.json();
    const notExpiredCoupons = this.filterExpiredCoupons(json);
    return notExpiredCoupons;
  }

  async loadCoupons() {
    const coupons = await this.fetchCoupons();
    const fragment = document.createDocumentFragment();
    const couponsNode = document.createElement('div');
    couponsNode.className = 'clipit-rotator__coupons';
    fragment.appendChild(couponsNode);
    coupons.forEach(coupon => {
      const { rendered: fullTitle } = coupon.title;
      const match = fullTitle.match(/^(.*?(free|off))/i);
      const shortTitle = match ? match[0] : [''];
      const subTitle = fullTitle.replace(shortTitle, '');
      const couponNode = document.createElement('a');
      couponNode.href = coupon.link;
      couponNode.classList.add('clipit-rotator__coupon');
      couponNode.innerHTML = `<span class="clipit-rotator__couponTitle">${shortTitle}</span><span class="clipit-rotator__couponSubtitle">${subTitle}</span>`;
      couponsNode.appendChild(couponNode);
    });
    const navPrev = document.createElement('span');
    navPrev.className = 'clipit-rotator__nav clipit-rotator__nav--previous';
    navPrev.innerHTML =
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path d="M4.2 247.5L151 99.5c4.7-4.7 12.3-4.7 17 0l19.8 19.8c4.7 4.7 4.7 12.3 0 17L69.3 256l118.5 119.7c4.7 4.7 4.7 12.3 0 17L168 412.5c-4.7 4.7-12.3 4.7-17 0L4.2 264.5c-4.7-4.7-4.7-12.3 0-17z"/></svg>';
    const navNext = document.createElement('span');
    navNext.className = 'clipit-rotator__nav clipit-rotator__nav--next';
    navNext.innerHTML =
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path d="M187.8 264.5L41 412.5c-4.7 4.7-12.3 4.7-17 0L4.2 392.7c-4.7-4.7-4.7-12.3 0-17L122.7 256 4.2 136.3c-4.7-4.7-4.7-12.3 0-17L24 99.5c4.7-4.7 12.3-4.7 17 0l146.8 148c4.7 4.7 4.7 12.3 0 17z"/></svg>';
    navPrev.addEventListener('click', () => this.previous());
    navNext.addEventListener('click', () => this.next());
    fragment.appendChild(navPrev);
    fragment.appendChild(navNext);

    this.parentNode.appendChild(fragment);
    this.couponNodes = couponsNode.children;
    const heightArray = Array.from(this.couponNodes).map(couponNode => {
      return couponNode.clientHeight;
    });
    const tallest = Math.max(...heightArray);
    this.parentNode.style.height = `${tallest + this.parentNode.clientHeight}px`;
    this.parentNode.classList.add('loaded');
    return true;
  }
}
