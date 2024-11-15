<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo e(config('app.settings.name', 'Laravel')); ?></title>
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
    <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
    <link href="<?php echo e(asset('vendor/quill/quill.snow.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/frontend.min.css')); ?>" rel="stylesheet">
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
        #input input[type=submit] {
            background: <?php echo e(config('app.settings.find_btn.color')); ?>;
            color: <?php echo e(config('app.settings.find_btn.text_color')); ?>;
        }
    </style>
    <style>
        <?php echo config('app.settings.global.css'); ?>

    </style>
</head>
<body>
    <div class="default-theme container">
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
            <div class="col-lg-5 col-md-6">
                <div class="input">
                    <form method="POST" id="input">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <input type="text" class="form-control" id="domain" name="domain" placeholder="www.example.com" required>
                            </div>
                            <div class="form-group col-md-3">
                                <select name="type" class="form-control" id="type">
                                    <option value="A" title="Host address (dotted quad)" <?php echo e((config('app.settings.default_dns') == 'A') ? 'selected' : ''); ?>>A</option>
                                    <option value="MX" title="Mail exchanger (preference value, domain name)" <?php echo e((config('app.settings.default_dns') == 'MX') ? 'selected' : ''); ?>>MX</option>
                                    <option value="NS" title="Authoritative nameserver (domain name)" <?php echo e((config('app.settings.default_dns') == 'NS') ? 'selected' : ''); ?>>NS</option>
                                    <option value="CNAME" title="Canonical name for an alias (domain name)" <?php echo e((config('app.settings.default_dns') == 'CNAME') ? 'selected' : ''); ?>>CNAME</option>
                                    <option value="TXT" title="Descriptive text (one or more strings)" <?php echo e((config('app.settings.default_dns') == 'TXT') ? 'selected' : ''); ?>>TXT</option>
                                    <option value="PTR" title="Domain name pointer (Provide IP Address)" <?php echo e((config('app.settings.default_dns') == 'PTR') ? 'selected' : ''); ?>>PTR</option>
                                    <option value="CAA" title="Certification Authority Authorization" <?php echo e((config('app.settings.default_dns') == 'CAA') ? 'selected' : ''); ?>>CAA</option>
                                    <option value="SOA" title="Start of Authority" <?php echo e((config('app.settings.default_dns') == 'SOA') ? 'selected' : ''); ?>>SOA</option>
                                    <option value="SRV" title="Service record" <?php echo e((config('app.settings.default_dns') == 'SRV') ? 'selected' : ''); ?>>SRV</option>
                                    <option value="AAAA" title="IP v6 address (address spec with colons)" <?php echo e((config('app.settings.default_dns') == 'AAAA') ? 'selected' : ''); ?>>AAAA</option>
                                </select>
                            </div>
                            <div class="form-group col-md-1 expected-icon">
                                <span onclick="document.getElementById('expected-group').classList.toggle('d-none'); document.getElementById('expected').value = ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="form-group col-md-3">
                                <input type="submit" class="form-control btn btn-warning" value="<?php echo e(config('app.settings.find_btn.text')); ?>">
                            </div>
                        </div>
                        <div id="expected-group" class="form-row d-none">
                            <div class="form-group col-12">
                                <input type="text" class="form-control" id="expected" name="expected" placeholder="Expected Value (Optional)">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="ad-space ad-space-2 d-flex align-items-center"><?php echo config('app.settings.ads.two'); ?></div>
                <div class="servers" id="list">
                    <ul class="list-group">
                        <?php $__currentLoopData = $servers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $server): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item" id="server-<?php echo e($server->id); ?>">
                            <span class="flag">
                                <img width="16px" src="<?php echo e(asset('images/flags/' . strtolower($server->country))); ?>.svg">
                            </span>
                            <span class="name"><?php echo e($server->name); ?></span>
                            <span class="result"></span>
                            <span class="status"><img src="images/status/pending.png"></span>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <div class="ad-space ad-space-4 d-flex align-items-center"><?php echo config('app.settings.ads.four'); ?></div>
            </div>
            <div class="col-lg-7 col-md-6">
                <div class="ad-space ad-space-1"><?php echo config('app.settings.ads.one'); ?></div>
                <div class="ql-editor"><?php echo config('app.settings.text.above_map'); ?></div>
                <div class="ad-space ad-space-3 d-flex align-items-center"><?php echo config('app.settings.ads.three'); ?></div>
                <div class="map">
                    <div id="map"></div>
                </div>
                <div class="ql-editor"><?php echo config('app.settings.text.below_map'); ?></div>
                <div class="ad-space ad-space-5 d-flex align-items-center"><?php echo config('app.settings.ads.five'); ?></div>
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
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
        </svg>
    </a>
    <?php endif; ?>
    <div class="d-none" id="servers"><?php echo e(json_encode($servers)); ?></div>
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
    <?php if(Illuminate\Support\Facades\Storage::disk('local')->has('public/images/custom-pending.png')): ?>
    <script>let pendingImg = `storage/images/custom-pending.png`;</script>
    <?php else: ?>
    <script>let pendingImg = `images/status/pending.png`;</script>
    <?php endif; ?>
    <script>
    <?php echo config('app.settings.global.js'); ?>

    </script>
    <?php echo config('app.settings.global.footer'); ?>

    <?php if(config('app.settings.map_fail_reloader', false)): ?>
    <script>
    window.addEventListener("load", function() {
        if(document.querySelector('#map > .jvectormap-container') === null) {
            let reloaded = localStorage.getItem('reloaded') ? localStorage.getItem('reloaded') : 0;
            if(parseInt(reloaded) < 5) {
                localStorage.setItem('reloaded', parseInt(reloaded) + 1);
                window.location.reload();
            }
        }
    });
    </script>
    <?php endif; ?>
    <?php if(config('app.settings.ad_block_detector_filename')): ?>
    <script src="<?php echo e(asset('storage/js/' . config('app.settings.ad_block_detector_filename'))); ?>" defer></script>
    <?php endif; ?>
    <script defer>
    setTimeout(() => {
        const enable_ad_block_detector = "<?php echo e(config('app.settings.enable_ad_block_detector', false) ? 1 : 0); ?>"
        if(!document.getElementById('fIeuXHFgWLES') && enable_ad_block_detector == "1") {
            document.querySelector('.default-theme').remove()
            document.querySelector('body > div').insertAdjacentHTML('beforebegin', `
                <div class="fixed w-screen h-screen bg-red-800 flex flex-col justify-center items-center gap-5 z-50 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-40 w-40" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd" />
                    </svg>
                    <h1 class="text-4xl font-bold"><?php echo e(__('Ad Blocker Detected')); ?></h1>
                    <h2><?php echo e(__('Disable the Ad Blocker to use ') . config('app.settings.name')); ?></h2>
                </div>
            `)
        }
    }, 500);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.1/axios.min.js" integrity="sha512-emSwuKiMyYedRwflbZB2ghzX8Cw8fmNVgZ6yQNNXXagFzFOaQmbvQ1vmDkddHjm5AITcBIZfC7k4ShQSjgPAmQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html><?php /**PATH /srv/http/localhost/resources/views/app.blade.php ENDPATH**/ ?>