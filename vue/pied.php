</main>

<footer>
    <span><span class="status-dot"></span>Système opérationnel</span>
    <span>CasZerne &mdash; <?= date('Y') ?></span>
</footer>

<script>
(function () {
    var dropdowns = document.querySelectorAll('.nav-dropdown');
    dropdowns.forEach(function (dd) {
        var trigger = dd.querySelector('.nav-dropdown-trigger');
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var isOpen = dd.classList.contains('open');
            dropdowns.forEach(function (other) { other.classList.remove('open'); });
            if (!isOpen) dd.classList.add('open');
            trigger.setAttribute('aria-expanded', String(!isOpen));
        });
    });
    document.addEventListener('click', function () {
        dropdowns.forEach(function (dd) { dd.classList.remove('open'); });
    });
})();
</script>

</body>
</html>
