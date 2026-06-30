(function () {
    var storageKey = 'ddm-theme';

    function getPreferredTheme() {
        var stored = localStorage.getItem(storageKey);
        if (stored === 'light' || stored === 'dark') {
            return stored;
        }
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        var meta = document.querySelector('meta[name="theme-color"]');
        if (meta) {
            var light = '#ffffff';
            var dark = '#111827';
            meta.setAttribute('content', theme === 'dark' ? dark : light);
        }
    }

    function toggleTheme() {
        var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        localStorage.setItem(storageKey, next);
        applyTheme(next);
    }

    applyTheme(getPreferredTheme());

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
            btn.addEventListener('click', toggleTheme);
        });
    });
})();
