<?php
$currentLang = 'es';
$assetsBase = '../assets/';
$langLinks = [
    'pt' => '../index.php',
    'en' => '../en/index.php',
    'es' => 'index.php',
    'de' => '../de/index.php',
    'zh' => '../zh/index.php',
];
$t = require __DIR__ . '/../includes/lang/es.php';
$langSwitcherLabel = $t['lang_switcher_label'];
require __DIR__ . '/../includes/layout.php';
