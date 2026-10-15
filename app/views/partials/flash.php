<?php if (!empty($_SESSION['flash'])): ?>
    <?php
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    $warna = $flash['type'] === 'success'
        ? 'background:#d4edda;color:#155724;border:1px solid #c3e6cb;'
        : 'background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;';
    ?>
    <div style="padding:10px;margin:10px 0;<?= $warna ?>">
        <?= htmlspecialchars($flash['message']) ?>
    </div>
<?php endif; ?>