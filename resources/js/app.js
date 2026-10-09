const promo = document.querySelector('[data-dismiss-promo]');
const menuToggle = document.querySelector('[data-menu-toggle]');
const mobileNav = document.querySelector('[data-mobile-nav]');
const searchInput = document.querySelector('[data-product-search]');
const cartCount = document.querySelector('[data-cart-count]');
const reviewTrack = document.querySelector('[data-review-track]');
const cartButton = document.querySelector('[data-cart-button]');
const cartDrawer = document.querySelector('[data-cart-drawer]');
const cartOverlay = document.querySelector('[data-cart-overlay]');
const cartItems = document.querySelector('[data-cart-items]');
const cartTotal = document.querySelector('[data-cart-total]');
const cartTitleCount = document.querySelector('[data-cart-title-count]');
const checkoutButton = document.querySelector('[data-checkout]');
const productModal = document.querySelector('[data-product-modal]');
const productModalOverlay = document.querySelector('[data-product-modal-overlay]');
const modalImage = document.querySelector('[data-modal-image]');
const modalName = document.querySelector('[data-modal-name]');
const modalSeller = document.querySelector('[data-modal-seller]');
const modalDescription = document.querySelector('[data-modal-description]');
const modalPrice = document.querySelector('[data-modal-price]');
const modalAdd = document.querySelector('[data-modal-add]');
const modalQuantity = document.querySelector('[data-modal-quantity]');
let selectedModalProduct = null;
let selectedModalQuantity = 1;
const cart = JSON.parse(localStorage.getItem('doyo-cart') ?? '{}');
const authPage = document.querySelector('[data-auth-page]');

const formatPrice = (price) => `$${price.toFixed(0)}`;

const setAuthMode = (mode) => {
	if (!authPage || !['login', 'register'].includes(mode)) return;
	authPage.classList.toggle('is-register', mode === 'register');
	authPage.dataset.authMode = mode;
	document.querySelectorAll('.auth-form-view').forEach((view) => {
		view.querySelectorAll('input').forEach((input) => {
			input.disabled = !view.classList.contains(`auth-${mode}-view`);
		});
	});
	document.querySelectorAll('[data-auth-toggle]').forEach((toggle) => {
		toggle.setAttribute('aria-pressed', String(toggle.dataset.authToggle === mode));
	});
};

document.querySelectorAll('[data-auth-toggle]').forEach((toggle) => {
	toggle.addEventListener('click', () => setAuthMode(toggle.dataset.authToggle));
});
setAuthMode(authPage?.dataset.authMode ?? 'login');

const saveCart = () => localStorage.setItem('doyo-cart', JSON.stringify(cart));

const getProduct = (id) => {
	const product = document.querySelector(`[data-product-id="${id}"]`);
	return product ? {
		id,
		name: product.dataset.productLabel,
		price: Number(product.dataset.productPrice),
	} : null;
};

const renderCart = () => {
	const entries = Object.values(cart);
	const count = entries.reduce((sum, item) => sum + item.quantity, 0);
	const total = entries.reduce((sum, item) => sum + (item.price * item.quantity), 0);

	if (cartCount) cartCount.textContent = String(count);
	if (cartTitleCount) cartTitleCount.textContent = `(${count})`;
	if (cartTotal) cartTotal.textContent = formatPrice(total);
	if (checkoutButton) checkoutButton.disabled = entries.length === 0;
	if (!cartItems) return;

	cartItems.innerHTML = entries.length === 0 ? '<p class="cart-empty">Votre panier est encore vide.</p>' : entries.map((item) => `
		<article class="cart-item">
			<div><strong>${item.name}</strong><span>${formatPrice(item.price)} l’unité</span></div>
			<div class="cart-item-actions"><div class="quantity-control"><button type="button" aria-label="Diminuer la quantité" data-cart-minus="${item.id}">−</button><span>${item.quantity}</span><button type="button" aria-label="Augmenter la quantité" data-cart-plus="${item.id}">+</button></div><button type="button" class="cart-remove" data-cart-remove="${item.id}">Supprimer</button></div>
		</article>
	`).join('');
};

const toggleCart = (isOpen) => {
	cartDrawer?.classList.toggle('is-open', isOpen);
	cartOverlay?.classList.toggle('is-visible', isOpen);
	cartDrawer?.setAttribute('aria-hidden', String(!isOpen));
};

const toggleProductModal = (isOpen, product = null) => {
	productModal?.classList.toggle('is-open', isOpen);
	productModalOverlay?.classList.toggle('is-visible', isOpen);
	productModal?.setAttribute('aria-hidden', String(!isOpen));
	if (!isOpen || !product) return;
	selectedModalProduct = product;
	selectedModalQuantity = 1;
	if (modalImage) {
		modalImage.src = product.image;
		modalImage.alt = product.name;
	}
	if (modalName) modalName.textContent = product.name;
	if (modalSeller) modalSeller.textContent = product.city ? `${product.seller} · ${product.city}` : product.seller;
	if (modalDescription) modalDescription.textContent = product.description || 'Une pièce sélectionnée par notre vendeur.';
	if (modalPrice) modalPrice.textContent = formatPrice(product.price);
	if (modalAdd) modalAdd.dataset.productId = product.id;
	if (modalQuantity) modalQuantity.textContent = '1';
	document.querySelectorAll('[data-modal-thumbnail] img').forEach((thumbnail) => {
		thumbnail.src = product.image;
		thumbnail.alt = product.name;
	});
};

const addToCart = (product, quantity = 1) => {
	if (!product) return;
	cart[product.id] = { ...product, quantity: (cart[product.id]?.quantity ?? 0) + quantity };
	saveCart();
	renderCart();
	toggleCart(true);
};

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
		const card = button.closest('[data-product]');
		if (!card) return;
		toggleProductModal(true, {
			id: card.dataset.productId,
			name: card.dataset.productLabel,
			image: card.dataset.productImage,
			description: card.dataset.productDescription,
			seller: card.dataset.productSeller,
			city: card.dataset.productCity,
			price: Number(card.dataset.productPrice),
		});
	});
});

document.querySelectorAll('[data-add-to-cart]').forEach((button) => {
	button.addEventListener('click', () => addToCart(getProduct(button.closest('[data-product]')?.dataset.productId)));
});

cartItems?.addEventListener('click', (event) => {
	const target = event.target.closest('button');
	const id = target?.dataset.cartMinus ?? target?.dataset.cartPlus ?? target?.dataset.cartRemove;
	if (!id || !cart[id]) return;
	if (target.dataset.cartRemove || (target.dataset.cartMinus && cart[id].quantity === 1)) delete cart[id];
	else if (target.dataset.cartMinus) cart[id].quantity -= 1;
	else cart[id].quantity += 1;
	saveCart();
	renderCart();
});

cartButton?.addEventListener('click', () => toggleCart(true));
document.querySelector('[data-cart-close]')?.addEventListener('click', () => toggleCart(false));
cartOverlay?.addEventListener('click', () => toggleCart(false));
document.querySelector('[data-product-modal-close]')?.addEventListener('click', () => toggleProductModal(false));
productModalOverlay?.addEventListener('click', () => toggleProductModal(false));
modalAdd?.addEventListener('click', () => {
	addToCart(getProduct(modalAdd.dataset.productId), selectedModalQuantity);
	toggleProductModal(false);
});
document.querySelector('[data-modal-minus]')?.addEventListener('click', () => {
	selectedModalQuantity = Math.max(1, selectedModalQuantity - 1);
	if (modalQuantity) modalQuantity.textContent = String(selectedModalQuantity);
});
document.querySelector('[data-modal-plus]')?.addEventListener('click', () => {
	selectedModalQuantity += 1;
	if (modalQuantity) modalQuantity.textContent = String(selectedModalQuantity);
});
document.querySelectorAll('[data-modal-thumbnail]').forEach((thumbnail) => {
	thumbnail.addEventListener('click', () => {
		document.querySelectorAll('[data-modal-thumbnail]').forEach((item) => item.classList.remove('is-active'));
		thumbnail.classList.add('is-active');
		if (modalImage && selectedModalProduct) modalImage.src = selectedModalProduct.image;
	});
});
document.querySelectorAll('.size-options button, .color-dot').forEach((option) => {
	option.addEventListener('click', () => {
		option.parentElement.querySelectorAll('button').forEach((item) => item.classList.remove('is-selected'));
		option.classList.add('is-selected');
	});
});

checkoutButton?.addEventListener('click', async () => {
	const entries = Object.values(cart);
	if (entries.length === 0) return;
	const total = entries.reduce((sum, item) => sum + (item.price * item.quantity), 0);
	const lines = entries.map((item) => `- ${item.name} x${item.quantity}: ${formatPrice(item.price * item.quantity)}`);
	const message = ['Bonjour DoYo.shop, je souhaite commander :', '', ...lines, '', `Total : ${formatPrice(total)}`, '', 'Merci de me confirmer la disponibilité et la livraison.'].join('\n');
	const phone = cartDrawer?.dataset.whatsappNumber ?? '';

	const orderItems = entries
		.filter((item) => /^\d+$/.test(String(item.id)))
		.map((item) => ({ product_id: Number(item.id), quantity: item.quantity }));

	if (orderItems.length > 0) {
		checkoutButton.disabled = true;
		try {
			const response = await fetch('/commandes', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'Accept': 'application/json',
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
				},
				body: JSON.stringify({ items: orderItems }),
			});

			if (!response.ok) {
				throw new Error('La demande de commande n’a pas pu être enregistrée.');
			}
		} catch (error) {
			console.error('Impossible d’enregistrer la demande de commande.', error);
			window.alert('La commande n’a pas pu être enregistrée. Veuillez réessayer.');
			return;
		} finally {
			checkoutButton.disabled = false;
		}
	}

	window.open(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`, '_blank', 'noopener');
});

renderCart();

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
