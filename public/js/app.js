'use strict';

window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.mk-navbar');
    if (navbar) {
        navbar.classList.toggle('scrolled', window.scrollY > 50);
    }
});

if ('IntersectionObserver' in window) {
    const imgObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                imgObserver.unobserve(img);
            }
        });
    }, { rootMargin: '200px' });

    document.querySelectorAll('img[data-src]').forEach(img => imgObserver.observe(img));
}

document.addEventListener('DOMContentLoaded', () => {
    const wisataApp = document.getElementById('wisataApp');
    if (wisataApp && typeof Vue !== 'undefined') {
        const { createApp } = Vue;
        createApp({
            data() {
                return {
                    filterKategori: '',
                    kategoriList: [
                        { val: '',        label: 'Semua',   icon: 'bi bi-grid' },
                        { val: 'alam',    label: 'Alam',    icon: 'bi bi-tree' },
                        { val: 'budaya',  label: 'Budaya',  icon: 'bi bi-building' },
                        { val: 'wahana',  label: 'Wahana',  icon: 'bi bi-stars' },
                        { val: 'kuliner', label: 'Kuliner', icon: 'bi bi-cup-hot' },
                    ]
                };
            },
            watch: {
                filterKategori(val) {
                    document.querySelectorAll('.mk-wisata-card-wrap').forEach(card => {
                        const kat = card.dataset.kategori || '';
                        card.style.display = (!val || kat === val) ? '' : 'none';
                    });
                }
            }
        }).mount('#wisataApp');
    }

    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) bsAlert.close();
        }, 5000);
    });

    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', e => {
            const target = document.querySelector(link.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    const starLabels = document.querySelectorAll('.mk-star-label');
    const starInputs = document.querySelectorAll('input[name="rating"]');
    if (starLabels.length && starInputs.length) {
        updateStars(5);

        starLabels.forEach((label, idx) => {
            label.addEventListener('click', () => {
                starInputs[idx].checked = true;
                updateStars(idx + 1);
            });

            label.addEventListener('mouseenter', () => highlightStars(idx + 1));
            label.addEventListener('mouseleave', () => {
                const checked = [...starInputs].findIndex(i => i.checked);
                updateStars(checked >= 0 ? checked + 1 : 0);
            });
        });

        function updateStars(count) {
            starLabels.forEach((l, i) => {
                const icon = l.querySelector('i');
                if (icon) {
                    icon.className = i < count ? 'bi bi-star-fill text-warning' : 'bi bi-star text-muted';
                }
            });
        }

        function highlightStars(count) {
            starLabels.forEach((l, i) => {
                const icon = l.querySelector('i');
                if (icon) {
                    icon.className = i < count ? 'bi bi-star-fill text-warning' : 'bi bi-star text-muted';
                }
            });
        }
    }

    const filterUlasan = document.getElementById('filterUlasanApp');
    if (filterUlasan && typeof Vue !== 'undefined') {
        const { createApp } = Vue;
        createApp({
            data() { return { filterRating: 0 }; },
            watch: {
                filterRating(val) {
                    document.querySelectorAll('#ulasanList .mk-ulasan-card').forEach(card => {
                        const rating = parseInt(card.dataset.rating || '0');
                        card.closest('div').style.display = (!val || rating === val) ? '' : 'none';
                    });
                }
            }
        }).mount('#filterUlasanApp');
    }
});