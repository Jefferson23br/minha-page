<?php
$currentLang = 'zh';
$assetsBase = '../assets/';
$langLinks = [
    'pt' => '../index.php',
    'en' => '../en/index.php',
    'es' => '../es/index.php',
    'de' => '../de/index.php',
    'zh' => 'index.php',
];
$t = require __DIR__ . '/../includes/lang/zh.php';
$langSwitcherLabel = $t['lang_switcher_label'];
require __DIR__ . '/../includes/layout.php';
