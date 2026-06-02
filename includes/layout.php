<?php
if (!function_exists('e')) {
    function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo e($t['html_lang']); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo e($t['meta_description']); ?>">
    <meta name="keywords" content="<?php echo e($t['meta_keywords']); ?>">
    <title><?php echo e($t['page_title']); ?></title>
    <link rel="stylesheet" href="<?php echo e($assetsBase); ?>css/style.css">
    <link rel="icon" href="<?php echo e($assetsBase); ?>images/logo1 (1).png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div id="loader" class="loader">
        <div class="loader-content">
            <div class="spinner"></div>
            <p><?php echo e($t['loader_text']); ?></p>
        </div>
    </div>
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="#" class="logo-img-link">
                    <img src="<?php echo e($assetsBase); ?>images/logo1 (1).png" alt="<?php echo e($t['logo_alt']); ?>" class="navbar-logo">
                </a>
                <?php require __DIR__ . '/lang-switcher.php'; ?>
            </div>
            <div class="hamburger-menu" id="hamburger">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <ul class="nav-links" id="navLinks">
                <li><a href="#about" class="nav-link"><?php echo e($t['nav_about']); ?></a></li>
                <li><a href="#github-chart" class="nav-link"><?php echo e($t['nav_github']); ?></a></li>
                <li><a href="#experience" class="nav-link"><?php echo e($t['nav_experience']); ?></a></li>
                <li><a href="#courses" class="nav-link"><?php echo e($t['nav_courses']); ?></a></li>
                <li><a href="#education" class="nav-link"><?php echo e($t['nav_education']); ?></a></li>
                <li><a href="#portfolio" class="nav-link"><?php echo e($t['nav_portfolio']); ?></a></li>
                <li><a href="#contact" class="nav-link"><?php echo e($t['nav_contact']); ?></a></li>
            </ul>
        </div>
    </nav>
    <header class="hero" id="hero">
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content">
                <div class="profile-image-wrapper">
                    <img src="<?php echo e($assetsBase); ?>images/Perfil.png" alt="<?php echo e($t['profile_alt']); ?>" class="profile-pic">
                </div>
                <h1 class="hero-title">Jefferson Lima</h1>
                <p class="hero-subtitle"><?php echo e($t['hero_subtitle']); ?></p>
                <p class="tagline"><?php echo e($t['hero_tagline']); ?></p>
                <div class="hero-buttons">
                    <a href="#contact" class="btn-primary"><?php echo e($t['hero_contact_button']); ?></a>
                    <a href="https://github.com/Jefferson23br" target="_blank" rel="noopener" class="btn-secondary"><?php echo e($t['hero_github_button']); ?></a>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="mouse"></div>
        </div>
    </header>
    <section id="about" class="section fade-in">
        <div class="container">
            <h2 class="section-title"><?php echo e($t['about_title']); ?></h2>
            <div class="about-grid">
                <div class="about-photo">
                    <img src="<?php echo e($assetsBase); ?>images/Perfil.png" alt="<?php echo e($t['about_photo_alt']); ?>">
                </div>
                <div class="about-content">
                    <p class="lead"><?php echo e($t['about_lead']); ?></p>
                    <div class="expertise-block">
                        <h3><?php echo e($t['about_expertise_title']); ?></h3>
                        <ul class="expertise-list">
                            <?php foreach ($t['about_expertise_list'] as $expertise): ?>
                                <li>
                                    <strong><?php echo e($expertise['title']); ?></strong>
                                    <?php echo e($expertise['text']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <p class="about-closing"><?php echo e($t['about_closing']); ?></p>
                </div>
            </div>
        </div>
    </section>
    <section id="github-chart" class="section fade-in">
        <div class="container">
            <div class="github-header">
                <div class="github-header__intro">
                    <h2 class="section-title"><?php echo e($t['github_title']); ?></h2>
                    <p class="section-subtitle"><?php echo e($t['github_subtitle']); ?></p>
                </div>
                <a href="https://github.com/Jefferson23br" target="_blank" rel="noopener" class="github-header__cta">
                    <?php echo e($t['github_cta']); ?>
                </a>
            </div>
            <?php
            require_once __DIR__ . '/github-profile-stats.php';
            require_once __DIR__ . '/github-languages.php';
            ?>
            <div class="github-panel">
                <div class="github-panel__row">
                    <article class="github-card">
                        <?php render_github_profile_stats($t); ?>
                    </article>
                    <article class="github-card">
                        <?php render_github_languages($t); ?>
                    </article>
                </div>
                <article class="github-card github-card--wide">
                    <div class="github-card__heading">
                        <span class="github-card__heading-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
                        <h3 class="github-card__title"><?php echo e($t['github_activity_title']); ?></h3>
                    </div>
                    <div class="github-activity">
                        <img src="https://ghchart.rshah.org/2563eb/Jefferson23br" alt="<?php echo e($t['github_chart_alt']); ?>" class="github-chart" loading="lazy" decoding="async">
                    </div>
                </article>
            </div>
            <div class="stacks-container">
                <h3 class="stacks-title"><?php echo e($t['stacks_title']); ?></h3>
                <div class="stacks-grid">
                    <img src="https://img.shields.io/badge/React-61DAFB?style=for-the-badge&logo=react&logoColor=black" alt="React" />
                    <img src="https://img.shields.io/badge/TypeScript-3178C6?style=for-the-badge&logo=typescript&logoColor=white" alt="TypeScript" />
                    <img src="https://img.shields.io/badge/Redux-764ABC?style=for-the-badge&logo=redux&logoColor=white" alt="Redux" />
                    <img src="https://img.shields.io/badge/Tailwind_CSS-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS" />
                    <img src="https://img.shields.io/badge/TanStack_Query-FF4154?style=for-the-badge&logo=react-query&logoColor=white" alt="TanStack Query" />
                    <img src="https://img.shields.io/badge/Node.js-339933?style=for-the-badge&logo=node.js&logoColor=white" alt="Node.js" />
                    <img src="https://img.shields.io/badge/NestJS-E0234E?style=for-the-badge&logo=nestjs&logoColor=white" alt="NestJS" />
                    <img src="https://img.shields.io/badge/JWT-000000?style=for-the-badge&logo=jsonwebtokens&logoColor=white" alt="JWT" />
                    <img src="https://img.shields.io/badge/Socket.io-010101?style=for-the-badge&logo=socket.io&logoColor=white" alt="Socket.io" />
                    <img src="https://img.shields.io/badge/PostgreSQL-4169E1?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL" />
                    <img src="https://img.shields.io/badge/Prisma-2D3748?style=for-the-badge&logo=prisma&logoColor=white" alt="Prisma" />
                    <img src="https://img.shields.io/badge/Redis-DC382D?style=for-the-badge&logo=redis&logoColor=white" alt="Redis" />
                    <img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker" />
                    <img src="https://img.shields.io/badge/Amazon_S3-569A31?style=for-the-badge&logo=amazon-s3&logoColor=white" alt="AWS S3" />
                    <img src="https://img.shields.io/badge/GitHub_Actions-2088FF?style=for-the-badge&logo=github-actions&logoColor=white" alt="GitHub Actions" />
                    <img src="https://img.shields.io/badge/Flutter-02569B?style=for-the-badge&logo=flutter&logoColor=white" alt="Flutter"/>
                    <img src="https://img.shields.io/badge/Dart-0175C2?style=for-the-badge&logo=dart&logoColor=white" alt="Dart"/>
                    <img src="https://img.shields.io/badge/Android-3DDC84?style=for-the-badge&logo=android&logoColor=white" alt="Android"/>
                    <img src="https://img.shields.io/badge/iOS-000000?style=for-the-badge&logo=apple&logoColor=white" alt="iOS"/>
                    <img src="https://img.shields.io/badge/Visual%20Studio%20Code-007ACC?style=for-the-badge&logo=visualstudiocode&logoColor=white" alt="VS Code"/>
                    <img src="https://img.shields.io/badge/React_Native-20232A?style=for-the-badge&logo=react&logoColor=61DAFB" alt="React Native"/>
                    <img src="https://img.shields.io/badge/Expo-000020?style=for-the-badge&logo=expo&logoColor=white" alt="Expo"/>
                    <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript"/>
                    <img src="https://img.shields.io/badge/GIT-E44C30?style=for-the-badge&logo=git&logoColor=white" alt="Git"/>
                    <img src="https://img.shields.io/badge/WordPress-21759B?style=for-the-badge&logo=wordpress&logoColor=white" alt="WordPress" />
                    <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
                    <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
                    <img src="https://img.shields.io/badge/C%2B%2B-00599C?style=for-the-badge&logo=cplusplus&logoColor=white" alt="C++" />
                    <img src="https://img.shields.io/badge/Python-3776AB?style=for-the-badge&logo=python&logoColor=white" alt="Python" />
                    <img src="https://img.shields.io/badge/VBA-217346?style=for-the-badge&logo=microsoftexcel&logoColor=white" alt="VBA" />
                    <img src="https://img.shields.io/badge/Figma-F24E1E?style=for-the-badge&logo=figma&logoColor=white" alt="Figma" />
                    <img src="https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite" />
                    <img src="https://img.shields.io/badge/React_Router-CA4245?style=for-the-badge&logo=react-router&logoColor=white" alt="React Router" />
                    <img src="https://img.shields.io/badge/shadcn/ui-000000?style=for-the-badge&logo=shadcnui&logoColor=white" alt="Shadcn UI" />
                    <img src="https://img.shields.io/badge/Radix_UI-161618?style=for-the-badge&logo=radix-ui&logoColor=white" alt="Radix UI" />
                    <img src="https://img.shields.io/badge/Framer_Motion-0055FF?style=for-the-badge&logo=framer&logoColor=white" alt="Framer Motion" />
                    <img src="https://img.shields.io/badge/Zustand-443E38?style=for-the-badge&logo=react&logoColor=white" alt="Zustand" />
                    <img src="https://img.shields.io/badge/React_Query-FF4154?style=for-the-badge&logo=react-query&logoColor=white" alt="React Query" />
                    <img src="https://img.shields.io/badge/Axios-5A29E4?style=for-the-badge&logo=axios&logoColor=white" alt="Axios" />
                    <img src="https://img.shields.io/badge/React_Hook_Form-EC5990?style=for-the-badge&logo=reacthookform&logoColor=white" alt="React Hook Form" />
                    <img src="https://img.shields.io/badge/Zod-3E67B1?style=for-the-badge&logo=zod&logoColor=white" alt="Zod" />
                    <img src="https://img.shields.io/badge/Recharts-FF6B6B?style=for-the-badge&logo=chart.js&logoColor=white" alt="Recharts" />
                    <img src="https://img.shields.io/badge/Express-000000?style=for-the-badge&logo=express&logoColor=white" alt="Express" />
                    <img src="https://img.shields.io/badge/Stripe-008CDD?style=for-the-badge&logo=stripe&logoColor=white" alt="Stripe" />
                    <img src="https://img.shields.io/badge/Mercado_Pago-00B1EA?style=for-the-badge&logo=mercadopago&logoColor=white" alt="Mercado Pago" />
                    <img src="https://img.shields.io/badge/Correios-FFD100?style=for-the-badge&logo=correios&logoColor=black" alt="Correios" />
                    <img src="https://img.shields.io/badge/Melhor_Envio-00A859?style=for-the-badge&logo=shipping&logoColor=white" alt="Melhor Envio" />
                    <img src="https://img.shields.io/badge/Vitest-6E9F18?style=for-the-badge&logo=vitest&logoColor=white" alt="Vitest" />
                    <img src="https://img.shields.io/badge/Testing_Library-E33332?style=for-the-badge&logo=testing-library&logoColor=white" alt="Testing Library" />
                    <img src="https://img.shields.io/badge/Playwright-2EAD33?style=for-the-badge&logo=playwright&logoColor=white" alt="Playwright" />
                    <img src="https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white" alt="GitHub" />
                    <img src="https://img.shields.io/badge/ESLint-4B32C3?style=for-the-badge&logo=eslint&logoColor=white" alt="ESLint" />
                    <img src="https://img.shields.io/badge/Prettier-F7B93E?style=for-the-badge&logo=prettier&logoColor=black" alt="Prettier" />
                    <img src="https://img.shields.io/badge/Vercel-000000?style=for-the-badge&logo=vercel&logoColor=white" alt="Vercel" />
                    <img src="https://img.shields.io/badge/Google_Analytics-E37400?style=for-the-badge&logo=google-analytics&logoColor=white" alt="Google Analytics" />
                    <img src="https://img.shields.io/badge/Google_Tag_Manager-246FDB?style=for-the-badge&logo=google-tag-manager&logoColor=white" alt="Google Tag Manager" />
                    <img src="https://img.shields.io/badge/React_Helmet-61DAFB?style=for-the-badge&logo=react&logoColor=black" alt="React Helmet" />
                </div>
            </div>
        </div>
    </section>
    <section id="experience" class="section fade-in">
        <div class="container">
            <h2 class="section-title"><?php echo e($t['experience_title']); ?></h2>
            <div class="timeline">
                <?php foreach ($t['jobs'] as $job): ?>
                    <div class="job-entry">
                        <div class="timeline-marker"></div>
                        <div class="job-content">
                            <h3><?php echo e($job['company']); ?></h3>
                            <p class="job-role"><?php echo e($job['role']); ?></p>
                            <p class="period"><?php echo e($job['period']); ?></p>
                            <p class="job-location"><?php echo e($job['location']); ?></p>
                            <?php foreach ($job['paragraphs'] as $paragraph): ?>
                                <p><?php echo e($paragraph); ?></p>
                            <?php endforeach; ?>
                            <?php if (!empty($job['list'])): ?>
                                <?php if (!empty($job['list_title'])): ?>
                                    <p><strong><?php echo e($job['list_title']); ?></strong></p>
                                <?php endif; ?>
                                <ul>
                                    <?php foreach ($job['list'] as $item): ?>
                                        <li><?php echo e($item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <?php if (!empty($job['highlights'])): ?>
                                <div class="job-highlights">
                                    <?php if (!empty($job['highlights_title'])): ?>
                                        <h4><?php echo e($job['highlights_title']); ?></h4>
                                    <?php endif; ?>
                                    <ul>
                                        <?php foreach ($job['highlights'] as $highlight): ?>
                                            <li><?php echo e($highlight); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($job['stack'])): ?>
                                <p class="job-stack"><strong><?php echo e($t['experience_stack_label']); ?></strong> <?php echo e($job['stack']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section id="courses" class="section fade-in">
        <div class="container">
            <h2 class="section-title"><?php echo e($t['courses_title']); ?></h2>
            <div class="courses-grid">
                <?php foreach ($t['courses'] as $course): ?>
                    <div class="course-entry">
                        <span class="course-issuer"><?php echo e($course['issuer']); ?></span>
                        <h3><?php echo e($course['title']); ?></h3>
                        <p class="period"><?php echo e($course['period']); ?></p>
                        <?php if (!empty($course['credential'])): ?>
                            <p class="course-credential"><?php echo e($course['credential']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($course['skills'])): ?>
                            <p class="course-skills"><?php echo e($course['skills']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section id="education" class="section fade-in">
        <div class="container">
            <h2 class="section-title"><?php echo e($t['education_title']); ?></h2>
            <div class="education-grid">
                <?php foreach ($t['education'] as $item): ?>
                    <div class="education-entry">
                        <div class="education-icon"><?php echo e($item['icon']); ?></div>
                        <h3><?php echo e($item['title']); ?></h3>
                        <p class="period"><?php echo e($item['period']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section id="portfolio" class="section fade-in">
        <div class="container">
            <h2 class="section-title"><?php echo e($t['portfolio_title']); ?></h2>
            <div class="portfolio-grid">
                <?php foreach ($t['portfolio'] as $project): ?>
                    <div class="project-entry">
                        <div class="project-icon"><?php echo e($project['icon']); ?></div>
                        <h3><?php echo e($project['title']); ?></h3>
                        <p><?php echo e($project['description']); ?></p>
                        <div class="project-tech">
                            <?php foreach ($project['tech'] as $tech): ?>
                                <span><?php echo e($tech); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php if (!empty($project['link_url']) && !empty($project['link_text'])): ?>
                            <a href="<?php echo e($project['link_url']); ?>" target="_blank" class="project-link"><?php echo e($project['link_text']); ?></a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section id="skills" class="section fade-in">
        <div class="container">
            <h2 class="section-title"><?php echo e($t['skills_title']); ?></h2>
            <div class="skills-grid">
                <?php foreach ($t['skills'] as $skill): ?>
                    <span class="skill-tag"><?php echo e($skill); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section id="additional-info" class="section fade-in">
        <div class="container">
            <h2 class="section-title"><?php echo e($t['additional_info_title']); ?></h2>
            <div class="info-grid">
                <?php foreach ($t['additional_info_items'] as $item): ?>
                    <div class="info-item">
                        <div class="info-icon"><?php echo e($item['icon']); ?></div>
                        <p><strong><?php echo e($item['label']); ?>:</strong> <?php echo e($item['value']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section id="contact" class="section fade-in">
        <div class="container">
            <h2 class="section-title"><?php echo e($t['contact_title']); ?></h2>
            <div class="contact-grid">
                <?php foreach ($t['contacts'] as $contact): ?>
                    <?php if (!empty($contact['href'])): ?>
                        <a href="<?php echo e($contact['href']); ?>"<?php echo !empty($contact['target_blank']) ? ' target="_blank"' : ''; ?> class="contact-item">
                            <div class="contact-icon"><?php echo e($contact['icon']); ?></div>
                            <div class="contact-info">
                                <h3><?php echo e($contact['title']); ?></h3>
                                <p><?php echo nl2br(e($contact['value'])); ?></p>
                            </div>
                        </a>
                    <?php else: ?>
                        <div class="contact-item">
                            <div class="contact-icon"><?php echo e($contact['icon']); ?></div>
                            <div class="contact-info">
                                <h3><?php echo e($contact['title']); ?></h3>
                                <p><?php echo nl2br(e($contact['value'])); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Jefferson Lima. <?php echo e($t['footer_rights']); ?></p>
        </div>
    </footer>
    <button id="backToTop" class="back-to-top" aria-label="<?php echo e($t['back_to_top_label']); ?>">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 15l-6-6-6 6"/>
        </svg>
    </button>

    <script src="<?php echo e($assetsBase); ?>js/script.js"></script>
</body>
</html>
