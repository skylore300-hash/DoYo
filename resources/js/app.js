const promo = document.querySelector('[data-dismiss-promo]');
const menuToggle = document.querySelector('[data-menu-toggle]');
const mobileNav = document.querySelector('[data-mobile-nav]');
const searchInput = document.querySelector('[data-product-search]');
const cartCount = document.querySelector('[data-cart-count]');
const reviewTrack = document.querySelector('[data-review-track]');

promo?.addEventListener('click', () => {
	promo.closest('.promo-bar')?.remove();
});

menuToggle?.addEventListener('click', () => {
	const isOpen = mobileNav?.classList.toggle('is-open') ?? false;
	menuToggle.setAttribute('aria-expanded', String(isOpen));
});

mobileNav?.querySelectorAll('a').forEach((link) => {
	link.addEventListener('click', () => {
		mobileNav.classList.remove('is-open');
		menuToggle?.setAttribute('aria-expanded', 'false');
	});
});

searchInput?.addEventListener('input', (event) => {
	const query = event.target.value.trim().toLowerCase();

	document.querySelectorAll('[data-product]').forEach((product) => {
		product.hidden = query !== '' && !product.dataset.productName.includes(query);
	});
});

document.querySelectorAll('.product-image').forEach((button) => {
	button.addEventListener('click', () => {
		button.closest('[data-product]')?.querySelector('.quick-view')?.classList.add('is-selected');
		if (cartCount) {
			cartCount.textContent = String(Number(cartCount.textContent) + 1);
		}
	});
});

document.querySelectorAll('[data-show-more]').forEach((button) => {
	button.addEventListener('click', () => {
		button.textContent = button.textContent.includes('Voir tout') ? 'Collection affichée ✓' : 'Voir tout →';
	});
});

document.querySelector('[data-review-prev]')?.addEventListener('click', () => {
	reviewTrack?.scrollBy({ left: -320, behavior: 'smooth' });
});

document.querySelector('[data-review-next]')?.addEventListener('click', () => {
	reviewTrack?.scrollBy({ left: 320, behavior: 'smooth' });
});

document.querySelector('[data-newsletter-form]')?.addEventListener('submit', (event) => {
	event.preventDefault();
	const message = event.currentTarget.querySelector('[data-form-message]');
	message.textContent = 'Merci, votre inscription est confirmée.';
	event.currentTarget.reset();
});
