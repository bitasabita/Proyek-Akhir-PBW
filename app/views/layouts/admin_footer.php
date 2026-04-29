    </div><!-- /p-4 page content -->
</div><!-- /mk-main-content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
<script>

    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('mkSidebar').classList.toggle('show');
    });
</script>
<?php if (isset($extraJs)) echo $extraJs; ?>
</body>
</html>
