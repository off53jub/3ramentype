/* Studio Audubon – main.js */

(function () {
    'use strict';

    // ===========================
    // Hero Slider
    // ===========================
    var slider = document.getElementById('heroSlider');
    if (slider) {
        var slides    = slider.querySelectorAll('.slide');
        var dots      = slider.querySelectorAll('.slider-dot');
        var btnPrev   = document.getElementById('sliderPrev');
        var btnNext   = document.getElementById('sliderNext');
        var current   = 0;
        var total     = slides.length;
        var timer     = null;
        var INTERVAL  = 5000;

        function goTo(index) {
            slides[current].classList.remove('is-active');
            if (dots[current]) {
                dots[current].classList.remove('is-active');
                dots[current].setAttribute('aria-selected', 'false');
            }

            current = (index + total) % total;

            slides[current].classList.add('is-active');
            if (dots[current]) {
                dots[current].classList.add('is-active');
                dots[current].setAttribute('aria-selected', 'true');
            }
        }

        function startAuto() {
            timer = setInterval(function () { goTo(current + 1); }, INTERVAL);
        }

        function resetAuto() {
            clearInterval(timer);
            startAuto();
        }

        if (btnNext) {
            btnNext.addEventListener('click', function () { goTo(current + 1); resetAuto(); });
        }

        if (btnPrev) {
            btnPrev.addEventListener('click', function () { goTo(current - 1); resetAuto(); });
        }

        dots.forEach(function (dot, i) {
            dot.addEventListener('click', function () { goTo(i); resetAuto(); });
        });

        // タッチスワイプ対応
        var touchStartX = 0;
        slider.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].clientX;
        }, { passive: true });

        slider.addEventListener('touchend', function (e) {
            var diff = touchStartX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 40) {
                goTo(diff > 0 ? current + 1 : current - 1);
                resetAuto();
            }
        }, { passive: true });

        // visibility が非表示のとき停止
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) { clearInterval(timer); } else { startAuto(); }
        });

        if (total > 1) { startAuto(); }
    }

    // ===========================
    // Mobile Menu
    // ===========================
    var toggle  = document.getElementById('menuToggle');
    var header  = document.getElementById('siteHeader');

    if (toggle && header) {
        // ナビリンクをオーバーレイ用に複製
        var origNav = header.querySelector('.nav-list');
        var overlay = document.createElement('nav');
        overlay.className = 'nav-overlay';
        overlay.setAttribute('aria-label', 'モバイルナビゲーション');

        if (origNav) {
            overlay.innerHTML = origNav.outerHTML;
        }
        document.body.appendChild(overlay);

        function openMenu() {
            toggle.classList.add('is-open');
            toggle.setAttribute('aria-expanded', 'true');
            overlay.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            toggle.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            overlay.classList.remove('is-open');
            document.body.style.overflow = '';
        }

        toggle.addEventListener('click', function () {
            overlay.classList.contains('is-open') ? closeMenu() : openMenu();
        });

        overlay.addEventListener('click', function (e) {
            if (e.target.tagName === 'A' || e.target === overlay) { closeMenu(); }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { closeMenu(); }
        });
    }

})();
