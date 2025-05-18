<!-- overlay-mobile.blade.php -->
<div @click="sidebarOpen = false"
     x-show="sidebarOpen"
     class="fixed inset-0 z-10 bg-black bg-opacity-50 md:hidden"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"></div>
