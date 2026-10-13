<?php

// @var $message string

?>

<?php if ($message): ?>
    <div class="message-container">
        <div class="message">
            <p>
                <?= $message ?>
            </p>
        </div>
    </div>
<?php endif; ?>
