<div id="icon-picker-overlay" class="fixed inset-0 bg-black/50 z-50 hidden" onclick="closeIconPicker()"></div>
<div id="icon-picker-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-[520px] flex flex-col" style="height:560px;">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Pilih Icon</h3>
            <button type="button" onclick="closeIconPicker()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500 hover:text-gray-700">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>
        <div class="px-4 pt-3 pb-2">
            <div class="relative">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="icon-search" placeholder="Cari icon..." class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" oninput="filterIcons(this.value)">
            </div>
        </div>
        <div id="icon-categories" class="flex flex-wrap gap-1.5 px-4 pb-3 border-b">
            <button type="button" onclick="filterCategory('all')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-blue-600 text-white">Semua</button>
            <button type="button" onclick="filterCategory('umum')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Umum</button>
            <button type="button" onclick="filterCategory('user')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">User</button>
            <button type="button" onclick="filterCategory('bisnis')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Bisnis</button>
            <button type="button" onclick="filterCategory('file')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">File</button>
            <button type="button" onclick="filterCategory('media')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Media</button>
            <button type="button" onclick="filterCategory('komunikasi')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Komunikasi</button>
            <button type="button" onclick="filterCategory('peta')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Lokasi</button>
            <button type="button" onclick="filterCategory('transportasi')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Transport</button>
            <button type="button" onclick="filterCategory('keamanan')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Keamanan</button>
            <button type="button" onclick="filterCategory('desain')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Desain</button>
            <button type="button" onclick="filterCategory('finance')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Keuangan</button>
            <button type="button" onclick="filterCategory('weather')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Cuaca</button>
            <button type="button" onclick="filterCategory('waktu')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Waktu</button>
            <button type="button" onclick="filterCategory('web')" class="icon-cat-btn px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Web</button>
        </div>
        <div id="icon-grid" class="overflow-y-auto p-3" style="display:grid;grid-template-columns:repeat(10,1fr);gap:2px;align-content:start;flex:1 1 0%;"></div>
        <div class="px-4 py-2 border-t bg-gray-50 rounded-b-xl text-xs text-gray-500 flex items-center gap-1">
            <span id="icon-count">0</span> icon &mdash; Klik untuk memilih
        </div>
    </div>
</div>

<script>
const iconCategories = {
    umum: ['ri-home-line','ri-home-smile-line','ri-home-gear-line','ri-building-line','ri-building-2-line','ri-building-4-line','ri-community-line','ri-city-line','ri-dashboard-line','ri-apps-line','ri-grid-line','ri-menu-line','ri-menu-2-line','ri-menu-3-line','ri-menu-4-line','ri-list-check','ri-list-unordered','ri-list-ordered','ri-more-line','ri-more-2-line','ri-add-line','ri-add-circle-line','ri-subtract-line','ri-close-line','ri-close-circle-line','ri-check-line','ri-check-double-line','ri-check-box-line','ri-edit-line','ri-pencil-line','ri-eraser-line','ri-delete-bin-line','ri-delete-bin-2-line','ri-refresh-line','ri-restart-line','ri-loop-left-line','ri-arrow-go-back-line','ri-arrow-go-forward-line','ri-save-line','ri-save-3-line','ri-download-line','ri-upload-line','ri-copy-line','ri-clipboard-line','ri-scissors-line','ri-drag-move-line','ri-drag-drop-line','ri-fullscreen-line','ri-zoom-in-line','ri-zoom-out-line','ri-sort-asc','ri-sort-desc','ri-search-line','ri-filter-line','ri-focus-line','ri-information-line','ri-question-line','ri-error-warning-line','ri-alert-line','ri-notification-line','ri-checkbox-blank-line','ri-radio-button-line','ri-toggle-line','ri-lock-line','ri-unlock-line','ri-key-line','ri-settings-3-line','ri-tools-line','ri-wrench-line','ri-hammer-line','ri-magic-line','ri-service-line','ri-code-line','ri-terminal-line','ri-bug-line','ri-cursor-line'],
    user: ['ri-user-line','ri-user-add-line','ri-user-minus-line','ri-user-settings-line','ri-user-follow-line','ri-user-star-line','ri-user-heart-line','ri-user-smile-line','ri-admin-line','ri-shield-user-line','ri-account-circle-line','ri-team-line','ri-group-line','ri-contacts-line','ri-ghost-line','ri-robot-line','ri-skull-line','ri-user-received-line','ri-user-shared-line','ri-user-search-line','ri-verified-badge-line','ri-vip-crown-line','ri-vip-crown-2-line','ri-vip-diamond-line','ri-emotion-line','ri-emotion-happy-line','ri-emotion-sad-line','ri-emotion-unhappy-line','ri-emotion-normal-line','ri-emotion-laugh-line','ri-mental-health-line','ri-medicine-bottle-line'],
    bisnis: ['ri-shopping-bag-line','ri-shopping-cart-line','ri-shopping-cart-2-line','ri-store-line','ri-store-2-line','ri-store-3-line','ri-gift-line','ri-price-tag-3-line','ri-coupon-line','ri-coupon-2-line','ri-seedling-line','ri-hand-coin-line','ri-box-line','ri-archive-line','ri-award-line','ri-medal-line','ri-trophy-line','ri-fire-line','ri-sparkling-line','ri-briefcase-line','ri-briefcase-2-line','ri-briefcase-3-line','ri-bar-chart-line','ri-bar-chart-2-line','ri-pie-chart-line','ri-pie-chart-2-line','ri-line-chart-line','ri-donut-chart-line','ri-funnel-line','ri-stock-line','ri-funds-line','ri-growth-line','ri-infinity-line','ri-scales-line'],
    file: ['ri-file-line','ri-file-copy-line','ri-file-text-line','ri-file-list-line','ri-file-paper-line','ri-file-chart-line','ri-file-stat-line','ri-file-excel-line','ri-file-word-line','ri-file-pdf-line','ri-file-image-line','ri-file-music-line','ri-file-video-line','ri-file-zip-line','ri-file-code-line','ri-file-shield-line','ri-file-lock-line','ri-folder-line','ri-folder-open-line','ri-folder-add-line','ri-draft-line','ri-newspaper-line','ri-news-line','ri-article-line','ri-pages-line','ri-book-line','ri-book-2-line','ri-bookmark-line','ri-book-open-line','ri-task-line','ri-task-list-line','ri-clipboard-line','ri-inbox-line','ri-outbox-line','ri-attachment-line','ri-link-line','ri-links-line'],
    media: ['ri-camera-line','ri-camera-lens-line','ri-image-line','ri-image-add-line','ri-image-edit-line','ri-gallery-line','ri-gallery-view-line','ri-video-line','ri-movie-line','ri-film-line','ri-clapperboard-line','ri-music-line','ri-music-2-line','ri-headphone-line','ri-mic-line','ri-mic-off-line','ri-volume-up-line','ri-volume-down-line','ri-volume-mute-line','ri-radio-line','ri-disc-line','ri-palette-line','ri-paint-line','ri-paint-brush-line','ri-brush-line','ri-quill-pen-line','ri-crop-line','ri-screenshot-line','ri-eye-line','ri-eye-off-line','ri-preview-line','ri-play-circle-line','ri-pause-circle-line','ri-record-circle-line','ri-speed-line','ri-subtitle-line'],
    komunikasi: ['ri-chat-1-line','ri-chat-2-line','ri-chat-3-line','ri-chat-check-line','ri-chat-delete-line','ri-chat-new-line','ri-chat-off-line','ri-message-line','ri-message-2-line','ri-message-3-line','ri-message-circle-line','ri-mail-line','ri-mail-open-line','ri-mail-add-line','ri-mail-check-line','ri-mail-send-line','ri-mail-unread-line','ri-phone-line','ri-smartphone-line','ri-tablet-line','ri-computer-line','ri-customer-service-line','ri-question-answer-line','ri-feedback-line','ri-discuss-line','ri-whatsapp-line','ri-telegram-line','ri-instagram-line','ri-facebook-line','ri-twitter-line','ri-youtube-line','ri-linkedin-line'],
    peta: ['ri-map-pin-line','ri-map-pin-2-line','ri-map-pin-3-line','ri-map-line','ri-map-2-line','ri-road-map-line','ri-compass-line','ri-compass-2-line','ri-compass-3-line','ri-compass-discover-line','ri-navigation-line','ri-route-line','ri-signpost-line','ri-gps-line','ri-landscape-line','ri-earth-line','ri-global-line','ri-anchor-line','ri-space-line','ri-rocket-line','ri-plane-line','ri-car-line','ri-bus-line','ri-train-line','ri-ship-line','ri-bike-line','ri-taxi-line','ri-roadster-line'],
    transportasi: ['ri-car-line','ri-car-washing-line','ri-roadster-line','ri-taxi-line','ri-bus-line','ri-bus-2-line','ri-truck-line','ri-train-line','ri-subway-line','ri-bike-line','ri-ebike-line','ri-motorbike-line','ri-plane-line','ri-plane-take-off-line','ri-plane-landing-line','ri-ship-line','ri-sailboat-line','ri-ferry-line','ri-rocket-line','ri-scooter-line','ri-wheelchair-line','ri-walk-line','ri-run-line','ri-riding-line','ri-gas-station-line','ri-parking-line','ri-traffic-light-line','ri-steering-line','ri-sailboat-line'],
    keamanan: ['ri-security-line','ri-shield-check-line','ri-shield-cross-line','ri-shield-flash-line','ri-shield-keyhole-line','ri-shield-line','ri-shield-star-line','ri-shield-user-line','ri-shield-warning-line','ri-lock-line','ri-unlock-line','ri-key-line','ri-key-2-line','ri-safe-line','ri-safe-2-line','ri-alarm-warning-line','ri-alarm-line','ri-scan-line','ri-qr-code-line','ri-barcode-line','ri-fingerprint-line','ri-fingerprint-2-line','ri-passport-line','ri-police-line','ri-spy-line','ri-door-line','ri-door-lock-line','ri-door-open-line','ri-gate-line','ri-verified-badge-line','ri-certificate-line','ri-shield-add-line'],
    desain: ['ri-pencil-line','ri-pencil-ruler-line','ri-paint-line','ri-paint-brush-line','ri-brush-line','ri-palette-line','ri-contrast-line','ri-ink-bottle-line','ri-markup-line','ri-font-size','ri-text-line','ri-bold-line','ri-italic-line','ri-underline-line','ri-strikethrough-line','ri-separator-line','ri-align-left-line','ri-align-center-line','ri-align-right-line','ri-align-justify-line','ri-layout-line','ri-layout-grid-line','ri-layout-masonry-line','ri-shape-line','ri-crop-line','ri-ruler-line','ri-drag-move-line','ri-drag-drop-line','ri-resize-line','ri-layer-line','ri-stack-line','ri-grid-line','ri-html5-line','ri-css3-line','ri-code-line','ri-code-box-line','ri-terminal-line','ri-git-branch-line','ri-git-merge-line','ri-bug-line','ri-cursor-line'],
    finance: ['ri-money-dollar-circle-line','ri-money-dollar-box-line','ri-money-euro-circle-line','ri-coin-line','ri-coins-line','ri-bank-line','ri-bank-card-line','ri-bank-card-2-line','ri-wallet-line','ri-wallet-2-line','ri-bill-line','ri-bill-2-line','ri-exchange-line','ri-exchange-dollar-line','ri-exchange-funds-line','ri-refund-line','ri-secure-payment-line','ri-coin-stack-line','ri-increase-decrease-line','ri-stock-line','ri-copper-coin-line','ri-gold-line','ri-scales-line','ri-receipt-line','ri-shopping-bag-line','ri-shopping-cart-line','ri-price-tag-line','ri-price-tag-2-line','ri-price-tag-3-line','ri-vip-crown-line','ri-vip-diamond-line','ri-vip-gift-line','ri-coupon-line','ri-discount-line','ri-auction-line','ri-bit-coin-line'],
    weather: ['ri-sun-line','ri-sun-cloudy-line','ri-sun-foggy-line','ri-moon-line','ri-moon-cloudy-line','ri-cloud-line','ri-cloudy-line','ri-cloud-windy-line','ri-foggy-line','ri-hail-line','ri-rain-line','ri-rainy-line','ri-showers-line','ri-snowy-line','ri-thunderstorms-line','ri-temp-hot-line','ri-temp-cold-line','ri-typhoon-line','ri-tornado-line','ri-windy-line','ri-water-flash-line','ri-rainbow-line','ri-fire-line','ri-leaf-line','ri-plant-line','ri-earth-line','ri-seedling-line','ri-flower-line','ri-tree-line','ri-haze-line','ri-mist-line','ri-sparkling-line','ri-heavy-showers-line'],
    waktu: ['ri-time-line','ri-timer-line','ri-timer-2-line','ri-hourglass-line','ri-clock-line','ri-calendar-line','ri-calendar-2-line','ri-calendar-event-line','ri-calendar-check-line','ri-calendar-todo-line','ri-calendar-clock-line','ri-history-line','ri-schedule-line','ri-alarm-line','ri-alarm-warning-line','ri-stop-circle-line','ri-days-line','ri-week-line','ri-month-line','ri-year-line','ri-todo-line','ri-speed-line','ri-date-range-line'],
    web: ['ri-global-line','ri-translate-line','ri-links-line','ri-share-line','ri-share-forward-line','ri-share-circle-line','ri-qr-code-line','ri-barcode-line','ri-radar-line','ri-wifi-line','ri-wifi-off-line','ri-bluetooth-line','ri-signal-wifi-line','ri-satellite-line','ri-cloud-line','ri-cloud-off-line','ri-cloud-download-line','ri-cloud-upload-line','ri-server-line','ri-database-line','ri-hard-drive-line','ri-upload-line','ri-download-line','ri-add-circle-line','ri-close-circle-line','ri-info-line','ri-spam-line','ri-forbid-line','ri-stop-line','ri-pause-line','ri-play-line','ri-skip-forward-line','ri-skip-back-line','ri-fast-forward-line','ri-rewind-line','ri-shuffle-line','ri-repeat-line','ri-cast-line','ri-apps-line','ri-apps-2-line','ri-radar-line','ri-logout-box-line','ri-login-box-line']
};

let currentCategory = 'all';

function openIconPicker() {
    document.getElementById('icon-picker-overlay').classList.remove('hidden');
    document.getElementById('icon-picker-modal').classList.remove('hidden');
    filterCategory('all');
    document.getElementById('icon-search').value = '';
    document.getElementById('icon-search').focus();
}

function closeIconPicker() {
    document.getElementById('icon-picker-overlay').classList.add('hidden');
    document.getElementById('icon-picker-modal').classList.add('hidden');
}

function filterCategory(cat) {
    currentCategory = cat;
    document.querySelectorAll('.icon-cat-btn').forEach(btn => {
        btn.className = btn.className.replace(/bg-blue-600 text-white/g, 'bg-gray-100 text-gray-700 hover:bg-gray-200');
    });
    event.target.className = event.target.className.replace(/bg-gray-100 text-gray-700 hover:bg-gray-200/g, 'bg-blue-600 text-white');
    renderIconsByCategory(cat);
}

function renderIconsByCategory(cat) {
    let icons;
    if (cat === 'all') {
        icons = Object.values(iconCategories).flat();
        icons = [...new Set(icons)];
    } else {
        icons = iconCategories[cat] || [];
    }
    renderIcons(icons);
}

function renderIcons(icons) {
    const grid = document.getElementById('icon-grid');
    grid.innerHTML = '';
    document.getElementById('icon-count').textContent = icons.length;
    icons.forEach(icon => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'flex items-center justify-center rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-500 transition cursor-pointer border border-transparent hover:border-blue-200';
        btn.title = icon;
        btn.innerHTML = '<i class="' + icon + ' text-xl"></i>';
        btn.onclick = function() { selectIcon(icon); };
        grid.appendChild(btn);
    });
}

function filterIcons(query) {
    const allIcons = Object.values(iconCategories).flat();
    const unique = [...new Set(allIcons)];
    if (!query) {
        if (currentCategory === 'all') { renderIcons(unique); }
        else { renderIcons(iconCategories[currentCategory] || []); }
        return;
    }
    const q = query.toLowerCase();
    const filtered = unique.filter(i => i.toLowerCase().includes(q));
    renderIcons(filtered);
}

function selectIcon(icon) {
    const input = document.getElementById('icon-input');
    input.value = icon;
    const oldPreview = input.parentElement.querySelector('.icon-inline-preview');
    if (oldPreview) oldPreview.remove();
    const span = document.createElement('span');
    span.className = 'icon-inline-preview absolute right-3 top-1/2 -translate-y-1/2';
    span.innerHTML = '<i class="' + icon + ' text-lg text-gray-600"></i>';
    input.parentElement.appendChild(span);
    closeIconPicker();
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeIconPicker();
});
</script>