/* Studio Audubon – main.js */

(function () {
    'use strict';

    // ===========================
    // Poster Banner (3-card auto-scroll)
    // ===========================
    var banner = document.getElementById('posterBanner');
    if (banner) {
        var track = document.getElementById('posterTrack');
        var prev  = document.getElementById('posterPrev');
        var next  = document.getElementById('posterNext');
        var cards = track.querySelectorAll('.poster-card');

        if (cards.length > 0) {
            var index    = 0;
            var INTERVAL = 5000;
            var timer;

            function visibleCount() {
                if (window.innerWidth <= 600) return 1;
                if (window.innerWidth <= 960) return 2;
                return 3;
            }

            function maxIndex() {
                return Math.max(0, cards.length - visibleCount());
            }

            function step() {
                if (cards.length <= visibleCount()) return; // 表示数以下なら動かさない
                var card = cards[0];
                var style = getComputedStyle(track);
                var gap   = parseFloat(style.columnGap || style.gap || '0');
                var width = card.getBoundingClientRect().width + gap;
                track.style.transform = 'translateX(' + (-width * index) + 'px)';
            }

            function goNext() {
                index = index >= maxIndex() ? 0 : index + 1;
                step();
            }
            function goPrev() {
                index = index <= 0 ? maxIndex() : index - 1;
                step();
            }

            function startAuto() {
                if (cards.length <= visibleCount()) return;
                timer = setInterval(goNext, INTERVAL);
            }
            function resetAuto() { clearInterval(timer); startAuto(); }

            if (next) next.addEventListener('click', function() { goNext(); resetAuto(); });
            if (prev) prev.addEventListener('click', function() { goPrev(); resetAuto(); });

            banner.addEventListener('mouseenter', function() { clearInterval(timer); });
            banner.addEventListener('mouseleave', function() { startAuto(); });

            var tx = 0;
            banner.addEventListener('touchstart', function(e) { tx = e.changedTouches[0].clientX; }, { passive: true });
            banner.addEventListener('touchend', function(e) {
                var diff = tx - e.changedTouches[0].clientX;
                if (Math.abs(diff) > 40) {
                    diff > 0 ? goNext() : goPrev();
                    resetAuto();
                }
            }, { passive: true });

            window.addEventListener('resize', function() {
                if (index > maxIndex()) index = maxIndex();
                step();
            });

            document.addEventListener('visibilitychange', function() {
                if (document.hidden) clearInterval(timer);
                else startAuto();
            });

            startAuto();
        }
    }

    // ===========================
    // Mobile Menu
    // ===========================
    var toggle  = document.getElementById('menuToggle');
    var header  = document.getElementById('siteHeader');

    if (toggle && header) {
        var origNav = header.querySelector('.nav-list');
        var overlay = document.createElement('nav');
        overlay.className = 'nav-overlay';
        overlay.setAttribute('aria-label', 'モバイルナビゲーション');
        if (origNav) overlay.innerHTML = origNav.outerHTML;
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

        toggle.addEventListener('click', function() {
            overlay.classList.contains('is-open') ? closeMenu() : openMenu();
        });
        overlay.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' || e.target === overlay) closeMenu();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeMenu();
        });
    }

    // ===========================
    // PDF Profile Download (single-actor)
    // ===========================
    var pdfBtn  = document.getElementById('downloadPdfBtn');
    var pdfArea = document.getElementById('pdfArea');

    if (pdfBtn && pdfArea && typeof window.html2pdf !== 'undefined') {
        pdfBtn.addEventListener('click', function() {
            var name = pdfBtn.dataset.name || 'profile';
            pdfBtn.disabled = true;
            var originalText = pdfBtn.innerHTML;
            pdfBtn.innerHTML = '生成中...';

            pdfArea.classList.add('is-rendering');

            window.html2pdf().set({
                margin:      [10, 10, 10, 10],
                filename:    name + '_profile.pdf',
                image:       { type: 'jpeg', quality: 0.95 },
                html2canvas: { scale: 2, useCORS: true, allowTaint: true, backgroundColor: '#ffffff' },
                jsPDF:       { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak:   { mode: ['avoid-all', 'css', 'legacy'] }
            }).from(pdfArea).save().then(function() {
                pdfArea.classList.remove('is-rendering');
                pdfBtn.disabled = false;
                pdfBtn.innerHTML = originalText;
            }).catch(function(err) {
                console.error('PDF generation failed:', err);
                pdfArea.classList.remove('is-rendering');
                pdfBtn.disabled = false;
                pdfBtn.innerHTML = originalText;
                alert('PDFの生成に失敗しました。');
            });
        });
    }

})();
