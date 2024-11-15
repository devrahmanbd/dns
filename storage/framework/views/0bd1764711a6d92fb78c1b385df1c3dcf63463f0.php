<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(config('app.settings.name', 'Laravel')); ?></title>
        <link rel="shortcut icon" href="<?php echo e(asset('images/favicon.png')); ?>" type="image/png">
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

        <!-- Styles -->
        <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <?php echo \Livewire\Livewire::styles(); ?>


        <!-- Scripts -->
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
    </head>
    <body class="font-sans antialiased">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.banner','data' => []]); ?>
<?php $component->withName('jet-banner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="min-h-screen bg-gray-100">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('navigation-menu')->html();
} elseif ($_instance->childHasBeenRendered('hal5I3q')) {
    $componentId = $_instance->getRenderedChildComponentId('hal5I3q');
    $componentTag = $_instance->getRenderedChildComponentTagName('hal5I3q');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('hal5I3q');
} else {
    $response = \Livewire\Livewire::mount('navigation-menu');
    $html = $response->html();
    $_instance->logRenderedChild('hal5I3q', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header class="bg-sky-500 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <main>
                <div class="mt-5 -mb-5 hidden annoucements" data-id="3">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="col-span-6">
                            <div class="w-full py-3 px-4 overflow-hidden sm:rounded-md flex items-center border bg-indigo-50 border-sky-600">
                                <div class="text-sky-600 w-10"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="text-sm text-gray-600 font-semibold"><?php echo e(__('Announcements')); ?></div>
                                    <div class="text-md">
                                        <?php echo e(__('We have added API support. Check it out ')); ?> <a class="font-medium underline" href="https://helpdesk.thehp.in/help-center/articles/37/how-to-use-api" target="_blank"><?php echo e(__('here')); ?></a>
                                    </div>
                                </div>
                                <div class="close text-sky-600 w-5 cursor-pointer"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo e($slot); ?>

            </main>
            
            <footer class="flex justify-center items-center text-sm text-gray-600 space-x-3 pb-10">
                <span><?php echo e(__('Global DNS - PHP')); ?></span>
                <span class="bg-sky-200 text-sky-800 px-2 py-1 text-xs rounded-full"><?php echo e(config('app.settings.version')); ?></span>
            </footer>
        </div>

        <?php echo $__env->yieldPushContent('modals'); ?>

        <?php echo \Livewire\Livewire::scripts(); ?>


        <?php echo $__env->yieldContent('addonJs'); ?>
        <script>
            const id = localStorage.getItem('annoucements');
            if(id) {
                const el = document.querySelector('.annoucements');
                if(el.dataset.id > id) {
                    el.classList.remove('hidden')
                }
            } else {
                document.querySelector('.annoucements').classList.remove('hidden')
            }
            document.querySelector('.annoucements .close') && document.querySelector('.annoucements .close').addEventListener('click', () => {
                localStorage.setItem('annoucements', document.querySelector('.annoucements').dataset.id);
                document.querySelector('.annoucements').remove();
            })
        </script>
    </body>
</html>
<?php /**PATH /srv/http/localhost/resources/views/layouts/app.blade.php ENDPATH**/ ?>