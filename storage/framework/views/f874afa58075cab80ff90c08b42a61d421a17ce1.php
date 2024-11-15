<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <?php if(isset($page)): ?>
    <?php echo $page->header; ?>

    <title><?php echo e($page->title); ?> - <?php echo e(config('app.settings.name')); ?></title>
    <?php else: ?>
    <title><?php echo e(config('app.settings.name')); ?></title>
    <?php endif; ?>
    <?php if(Illuminate\Support\Facades\Storage::disk('local')->has('public/images/custom-favicon.png')): ?>
    <link rel="icon" href="<?php echo e(url('storage/images/custom-favicon.png')); ?>" type="image/png">
    <?php else: ?>
    <link rel="icon" href="<?php echo e(asset('images/favicon.png')); ?>" type="image/png">
    <?php endif; ?>

    <?php echo config('app.settings.global.header'); ?>

    
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/frontend.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('js/scripts.js')); ?>" defer></script>

    <!-- jVectorMap Scripts -->
    <script src="<?php echo e(asset('vendor/jvectormap/jquery-jvectormap-2.0.5.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('vendor/jvectormap/jquery-jvectormap-world-mill.js')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=<?php echo e(config('app.settings.font_family')); ?>:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <!-- jVectorMap Styles -->
    <link href="<?php echo e(asset('vendor/jvectormap/jquery-jvectormap-2.0.5.css')); ?>" rel="stylesheet">

    <!-- ShortcodeJS -->
    <script src="<?php echo e(asset('vendor/shortcode/shortcode.js')); ?>"></script>

    <!-- Styles -->
    <link href="<?php echo e(asset('vendor/quill/quill.snow.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/frontend.min.css')); ?>" rel="stylesheet">
    <?php if(Illuminate\Support\Facades\Storage::disk('local')->has('public/images/custom-success.png')): ?>
    <script>let successImg = `storage/images/custom-success.png`;</script>
    <?php else: ?>
    <script>let successImg = `images/status/success.png`;</script>
    <?php endif; ?>
    <?php if(Illuminate\Support\Facades\Storage::disk('local')->has('public/images/custom-error.png')): ?>
    <script>let errorImg = `storage/images/custom-error.png`;</script>
    <?php else: ?>
    <script>let errorImg = `images/status/error.png`;</script>
    <?php endif; ?>
    <style>
        .darkmode--activated .navbar-light .navbar-nav a.nav-link {
            color: #fff;
        }
        .navbar-light .navbar-nav a.nav-link {
            color: #000;
            transition: all 0.3s;
        }
        .socials {
            font-size: 1.2rem;
        }
        .socials a:not(:last-child) {
            margin-right: 1rem;
        }
        .navbar-light .navbar-nav a.nav-link:hover {
            transform: translate(0, -5px);
        }
        .ql-editor {
            height: auto;
            overflow: hidden;
            padding-top: 0px;
        }
        body {
            font-family: "<?php echo e(config('app.settings.font_family')); ?>";
        }
        #whois input[type=submit] {
            background: <?php echo e(config('app.settings.whois_btn.color')); ?>;
            color: <?php echo e(config('app.settings.whois_btn.text_color')); ?>;
        }
        #ip input[type=submit] {
            background: <?php echo e(config('app.settings.ip_btn.color')); ?>;
            color: <?php echo e(config('app.settings.ip_btn.text_color')); ?>;
        }
        #blacklist input[type=submit] {
            background: <?php echo e(config('app.settings.blacklist_btn.color')); ?>;
            color: <?php echo e(config('app.settings.blacklist_btn.text_color')); ?>;
        }
        #dmarc input[type=submit] {
            background: <?php echo e(config('app.settings.dmarc_btn.color')); ?>;
            color: <?php echo e(config('app.settings.dmarc_btn.text_color')); ?>;
        }
        #blacklist-results > .row {
            margin-right: -8px;
            margin-left: -8px;
        }
        #blacklist-results > .row > * {
            padding-right: 8px;
            padding-left: 8px;
        }
        .gap-5 {
            gap: 5px;
        }
    </style>
    <style>
        <?php echo config('app.settings.global.css'); ?>

    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light justify-content-between px-0 mt-5">
            <?php if(Illuminate\Support\Facades\Storage::disk('local')->has('public/images/custom-logo.png')): ?>
            <a class="navbar-brand" href="/"><img src="<?php echo e(url('storage/images/custom-logo.png')); ?>" alt="logo"></a>
            <?php else: ?>
            <a class="navbar-brand" href="/"><img src="<?php echo e(asset('images/logo.png')); ?>" alt="logo"></a>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($menu->hasChild()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink<?php echo e($menu->id); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo e(__($menu->name)); ?>

                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink<?php echo e($menu->id); ?>">
                                <?php $__currentLoopData = $menu->getChild(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="dropdown-item" href="<?php echo e($child->link); ?>" target="<?php echo e($child->target); ?>"><?php echo e(__($child->name)); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </li>
                    <?php else: ?>
                        <?php if($menu->parent_id === null): ?>
                        <li class="nav-item <?php echo e(url()->current() === $menu->link ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e($menu->link); ?>" target="<?php echo e($menu->target); ?>"><?php echo e(__($menu->name)); ?></a>
                        </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </nav>
        <div class="row mt-5">
            <div class="ad-space ad-space-1 d-flex align-items-center"><?php echo config('app.settings.ads.one'); ?></div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <?php if($page->slug == 'whois' || $page->slug == 'ip' || $page->slug == 'blacklist' || $page->slug == 'dmarc'): ?>
                <?php echo $page->content->one; ?>

                <?php if($page->slug == 'whois'): ?>
                <div id="whois" class="input">
                    <form method="POST" action="<?php echo e(route('whois')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control" id="domain" name="domain" value="<?php echo e($page->domain); ?>" placeholder="example.com" required>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="submit" class="form-control btn" value="<?php echo e(config('app.settings.whois_btn.text')); ?>">
                            </div>
                        </div>
                    </form>
                    <?php if($page->whois): ?>
                    <div><?php echo $page->whois; ?></div>
                    <?php endif; ?>
                </div>
                <?php elseif($page->slug == 'ip'): ?>
                <div id="ip" class="input">
                    <form method="POST" action="<?php echo e(route('ip')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control" id="ip" name="ip" value="<?php echo e($page->ip); ?>" placeholder="1.2.3.4" required>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="submit" class="form-control btn" value="<?php echo e(config('app.settings.ip_btn.text')); ?>">
                            </div>
                        </div>
                    </form>
                    <?php if($page->info): ?>
                    <div class="container">
                        <div class="row">
                            <?php $__currentLoopData = $page->info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!in_array($label, $page->ignore)): ?>
                            <div class="col-12 col-md-6 col-lg-4 p-0 mb-2">
                                <?php if(isset($page->headers[$label])): ?>
                                <div><?php echo e($page->headers[$label]); ?></div>
                                <?php else: ?>
                                <div><?php echo e(ucfirst($label)); ?></div>
                                <?php endif; ?>
                                <strong><?php echo e($value); ?></strong>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php elseif($page->slug == 'blacklist'): ?>
                <div id="blacklist" class="input">
                    <form action="#" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control" name="input" placeholder="example.com or 1.2.3.4" required>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="submit" class="form-control btn" value="<?php echo e(config('app.settings.blacklist_btn.text')); ?>" data-value="<?php echo e(config('app.settings.blacklist_btn.text')); ?>">
                            </div>
                        </div>
                    </form>
                    <div id="blacklist-results"><div class="row"></div></div>
                </div>
                <?php elseif($page->slug == 'dmarc'): ?>
                <div id="dmarc" class="input">
                    <form action="#" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control" name="input" placeholder="example.com" required>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="submit" class="form-control btn" value="<?php echo e(config('app.settings.dmarc_btn.text')); ?>" data-value="<?php echo e(config('app.settings.dmarc_btn.text')); ?>">
                            </div>
                        </div>
                    </form>
                    <div id="dmarc-results"></div>
                </div>
                <?php endif; ?>
                <?php echo $page->content->two; ?>

                <?php else: ?>
                <?php echo $page->content; ?>

                <?php endif; ?>
            </div>
        </div>
        <div class="row mt-5">
            <div class="ad-space ad-space-6 d-flex align-items-center"><?php echo config('app.settings.ads.six'); ?></div>
        </div>
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center align-items-center socials">
                <?php $__currentLoopData = config('app.settings.socials'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($social['link']); ?>" target="_blank" class="text-lg" rel="noopener noreferrer"><i class="<?php echo e($social['icon']); ?>"></i></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="ql-editor col-12">
                <?php echo config('app.settings.text.footer'); ?>

            </div>
        </div>
    </div>
    <?php if(Auth::check()): ?>
    <a id="admin-icon" href="<?php echo e(route('admin')); ?>" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
        </svg>
    </a>
    <?php endif; ?>
    <div class="d-none" id="servers"><?php echo e(json_encode([])); ?></div>
    <div class="d-none" id="options"><?php echo e(json_encode(config('app.settings'))); ?></div>
    <?php if(config('app.settings.show_dark_mode')): ?>
    <!-- DarkMode.JS Scripts -->
    <script src="<?php echo e(asset('vendor/darkmode/darkmode-js.min.js')); ?>"></script>
    <script>
        function addDarkmodeWidget() {
            new Darkmode({ label: '🌓' }).showWidget();
        }
        window.addEventListener('load', addDarkmodeWidget);
    </script>
    <?php endif; ?>
    <?php if($page->slug == 'whois'): ?>
    <script defer>
        let whois = setInterval(() => {
            if(document.querySelector('#whois form')) {
                document.querySelector('#whois form').addEventListener('submit', e => {
                    e.preventDefault();
                    document.querySelector('#whois form input[type="text"]').value = document.querySelector('#whois form input[type="text"]').value.replace('http://', '').replace('https://', '').split(/[/?#]/)[0];
                    document.querySelector('#whois form input[type="submit"]').disabled = true;
                    document.querySelector('#whois form input[type="submit"]').value = '. . .';
                    document.querySelector('#whois form').submit();
                })
                clearInterval(whois)
            }
        }, 1000);
    </script>
    <?php endif; ?>
    <?php if($page->slug == 'ip'): ?>
    <script defer>
        let ip = setInterval(() => {
            if(document.querySelector('#ip form')) {
                document.querySelector('#ip form').addEventListener('submit', e => {
                    e.preventDefault();
                    document.querySelector('#ip form input[type="text"]').value = document.querySelector('#ip form input[type="text"]').value.replace('http://', '').replace('https://', '').split(/[/?#]/)[0];
                    document.querySelector('#ip form input[type="submit"]').disabled = true;
                    document.querySelector('#ip form input[type="submit"]').value = '. . .';
                    document.querySelector('#ip form').submit();
                })
                clearInterval(ip)
            }
        }, 1000);
    </script>
    <?php endif; ?>
    <script>
    <?php echo config('app.settings.global.js'); ?>

    </script>
    <?php echo config('app.settings.global.footer'); ?>

    <script>
       const blacklists = <?php echo json_encode(config('app.settings.blacklist.servers')); ?>

    </script>
</body>
</html><?php /**PATH /srv/http/localhost/resources/views/page.blade.php ENDPATH**/ ?>