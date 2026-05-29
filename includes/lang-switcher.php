<?php
/**
 * @var array<string, string> $langLinks
 * @var string $currentLang
 */
$langMeta = [
    'pt' => ['iso' => 'br', 'label' => 'Português', 'country' => 'Brasil'],
    'en' => ['iso' => 'us', 'label' => 'English', 'country' => 'United States'],
    'es' => ['iso' => 'es', 'label' => 'Español', 'country' => 'España'],
    'de' => ['iso' => 'de', 'label' => 'Deutsch', 'country' => 'Deutschland'],
    'zh' => ['iso' => 'cn', 'label' => '中文', 'country' => '中国'],
];
$langSwitcherLabel = $langSwitcherLabel ?? 'Selecionar idioma';
$flagBase = ($assetsBase ?? 'assets/') . 'images/flags/';
$currentMeta = $langMeta[$currentLang] ?? $langMeta['pt'];
?>
<div class="lang-switcher" id="langSwitcher">
    <button type="button" class="lang-toggle" id="langToggle" aria-label="<?php echo htmlspecialchars($langSwitcherLabel); ?>" aria-expanded="false" aria-haspopup="true">
        <img class="lang-toggle-img"
             src="<?php echo htmlspecialchars($flagBase . $currentMeta['iso'] . '.png'); ?>"
             width="48"
             height="36"
             alt=""
             decoding="async">
        <svg class="lang-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path d="M6 9l6 6 6-6"/>
        </svg>
    </button>
    <div class="lang-dropdown" id="langDropdown" role="menu" hidden>
        <?php foreach ($langMeta as $code => $meta): ?>
            <?php if (!isset($langLinks[$code])) continue; ?>
            <a href="<?php echo htmlspecialchars($langLinks[$code]); ?>"
               class="lang-option<?php echo $currentLang === $code ? ' is-active' : ''; ?>"
               role="menuitem"
               title="<?php echo htmlspecialchars($meta['country'] . ' — ' . $meta['label']); ?>">
                <img class="lang-menu-img"
                     src="<?php echo htmlspecialchars(($assetsBase ?? 'assets/') . 'images/flags/' . $meta['iso'] . '.png'); ?>"
                     width="48"
                     height="36"
                     alt=""
                     loading="lazy"
                     decoding="async">
                <span class="lang-option-text">
                    <span class="lang-country"><?php echo htmlspecialchars($meta['country']); ?></span>
                    <span class="lang-name"><?php echo htmlspecialchars($meta['label']); ?></span>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
