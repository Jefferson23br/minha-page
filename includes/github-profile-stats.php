<?php

declare(strict_types=1);

function fetch_github_user(string $username): ?array
{
    $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '', $username) ?: 'user';
    $cacheDir = __DIR__ . '/cache';
    $cacheFile = $cacheDir . '/github_user_' . $safeName . '.json';
    $ttl = 3600;

    if (is_readable($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
        $cached = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($cached) && !empty($cached['login'])) {
            return $cached;
        }
    }

    $url = 'https://api.github.com/users/' . rawurlencode($username);
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: JeffersonLima-Portfolio\r\nAccept: application/vnd.github+json\r\n",
            'timeout' => 12,
            'ignore_errors' => true,
        ],
    ]);

    $body = @file_get_contents($url, false, $context);
    if ($body !== false) {
        $data = json_decode($body, true);
        if (is_array($data) && !empty($data['login'])) {
            if (!is_dir($cacheDir)) {
                @mkdir($cacheDir, 0755, true);
            }
            @file_put_contents($cacheFile, json_encode($data));
            return $data;
        }
    }

    if (is_readable($cacheFile)) {
        $stale = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($stale) && !empty($stale['login'])) {
            return $stale;
        }
    }

    return null;
}

function format_github_contribution_count(int $count, string $lang): string
{
    if ($count >= 1000) {
        $value = round($count / 1000, 1);
        $formatted = number_format($value, 1, '.', '');
        $decimalSep = in_array($lang, ['en', 'zh'], true) ? '.' : ',';
        return str_replace('.', $decimalSep, $formatted) . 'k';
    }

    $thousandsSep = in_array($lang, ['en', 'zh'], true) ? ',' : '.';
    return number_format($count, 0, '', $thousandsSep);
}

function fetch_github_contributions_year(string $username, ?int $year = null): ?int
{
    $year = $year ?? (int) date('Y');
    $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '', $username) ?: 'user';
    $cacheDir = __DIR__ . '/cache';
    $cacheFile = $cacheDir . '/github_contributions_' . $safeName . '_' . $year . '.json';
    $ttl = 3600;

    if (is_readable($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
        $cached = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($cached) && isset($cached['count'])) {
            return (int) $cached['count'];
        }
    }

    $url = 'https://github-contributions-api.jogruber.de/v4/' . rawurlencode($username) . '?y=' . $year;
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: JeffersonLima-Portfolio\r\nAccept: application/json\r\n",
            'timeout' => 15,
            'ignore_errors' => true,
        ],
    ]);

    $body = @file_get_contents($url, false, $context);
    $count = null;

    if ($body !== false) {
        $data = json_decode($body, true);
        if (is_array($data)) {
            if (isset($data['total'][(string) $year])) {
                $count = (int) $data['total'][(string) $year];
            } elseif (!empty($data['contributions']) && is_array($data['contributions'])) {
                $count = 0;
                foreach ($data['contributions'] as $day) {
                    $count += (int) ($day['count'] ?? 0);
                }
            }
        }
    }

    if ($count === null && is_readable($cacheFile)) {
        $stale = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($stale) && isset($stale['count'])) {
            return (int) $stale['count'];
        }
        return null;
    }

    if ($count !== null) {
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }
        @file_put_contents($cacheFile, json_encode(['count' => $count, 'year' => $year]));
    }

    return $count;
}

function render_github_profile_stats(array $t, string $username = 'Jefferson23br'): void
{
    $user = fetch_github_user($username);
    $ariaLabel = $t['github_stats_alt'] ?? ('GitHub stats ' . $username);
    $profileUrl = 'https://github.com/' . rawurlencode($username);

    echo '<div class="github-profile" role="img" aria-label="' . e($ariaLabel) . '">';

    if ($user === null) {
        echo '<p class="github-profile__empty">' . e($t['github_stats_unavailable'] ?? 'Stats temporarily unavailable.') . '</p>';
        echo '<a href="' . e($profileUrl) . '" target="_blank" rel="noopener" class="github-profile__link">@' . e($username) . '</a>';
        echo '</div>';
        return;
    }

    $repos = (int) ($user['public_repos'] ?? 0);
    $followers = (int) ($user['followers'] ?? 0);
    $following = (int) ($user['following'] ?? 0);
    $login = (string) ($user['login'] ?? $username);
    $name = trim((string) ($user['name'] ?? ''));
    $avatar = (string) ($user['avatar_url'] ?? '');
    $sinceYear = '';
    if (!empty($user['created_at'])) {
        $sinceYear = date('Y', strtotime((string) $user['created_at']));
    }

    echo '<div class="github-profile__head">';
    if ($avatar !== '') {
        echo '<div class="github-profile__avatar-wrap">';
        echo '<img class="github-profile__avatar" src="' . e($avatar) . '" alt="" width="72" height="72" loading="lazy" decoding="async">';
        echo '</div>';
    }
    echo '<div class="github-profile__identity">';
    echo '<span class="github-profile__badge">GitHub</span>';
    if ($name !== '') {
        echo '<span class="github-profile__name">' . e($name) . '</span>';
    }
    echo '<a href="' . e($profileUrl) . '" target="_blank" rel="noopener" class="github-profile__login">@' . e($login) . '</a>';
    echo '</div>';
    echo '</div>';

    $year = (int) date('Y');
    $contributions = fetch_github_contributions_year($username, $year);
    if ($contributions !== null) {
        $lang = (string) ($t['html_lang'] ?? 'pt');
        $countLabel = format_github_contribution_count($contributions, $lang);
        $eyebrow = sprintf($t['github_commits_eyebrow'] ?? 'Commits in %s', (string) $year);
        $caption = $t['github_commits_caption'] ?? 'GitHub contributions';
        $countHtml = e($countLabel);
        if (preg_match('/^(.+)(k)$/iu', $countLabel, $parts)) {
            $countHtml = e($parts[1]) . '<span class="github-profile__commits-suffix">' . e($parts[2]) . '</span>';
        }
        echo '<div class="github-profile__commits">';
        echo '<div class="github-profile__commits-shine" aria-hidden="true"></div>';
        echo '<div class="github-profile__commits-body">';
        echo '<div class="github-profile__commits-icon" aria-hidden="true">';
        echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3.5"/><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/></svg>';
        echo '</div>';
        echo '<div class="github-profile__commits-text">';
        echo '<p class="github-profile__commits-eyebrow">' . e($eyebrow) . '</p>';
        echo '<p class="github-profile__commits-value">' . $countHtml . '</p>';
        echo '<p class="github-profile__commits-caption">' . e($caption) . '</p>';
        echo '</div></div></div>';
    }

    $statItems = [
        ['class' => 'repos', 'label' => $t['github_stat_repos'], 'value' => (string) $repos, 'paths' => ['M4 19.5A2.5 2.5 0 0 1 6.5 17H20', 'M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z']],
        ['class' => 'followers', 'label' => $t['github_stat_followers'], 'value' => (string) $followers, 'paths' => ['M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2', 'M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z']],
        ['class' => 'following', 'label' => $t['github_stat_following'], 'value' => (string) $following, 'paths' => ['M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2', 'M12 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8z']],
    ];
    if ($sinceYear !== '') {
        $statItems[] = ['class' => 'since', 'label' => $t['github_stat_since'], 'value' => $sinceYear, 'paths' => ['M8 2v4', 'M16 2v4', 'M3 10h18', 'M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z']];
    }

    echo '<dl class="github-profile__stats">';
    foreach ($statItems as $item) {
        echo '<div class="github-profile__stat github-profile__stat--' . e($item['class']) . '">';
        echo '<span class="github-profile__stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">';
        foreach ($item['paths'] as $path) {
            echo '<path d="' . e($path) . '"/>';
        }
        echo '</svg></span>';
        echo '<dt>' . e($item['label']) . '</dt>';
        echo '<dd>' . e($item['value']) . '</dd>';
        echo '</div>';
    }
    echo '</dl>';
    echo '</div>';
}
