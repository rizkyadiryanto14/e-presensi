<style>
    .transition-smooth {
        transition: all 0.3s ease-in-out;
    }
    .sidebar-item {
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }
    .sidebar-item.active {
        border-left-color: #2563eb;
        background-color: rgba(37, 99, 235, 0.1);
    }
    .dark .sidebar-item.active {
        border-left-color: #3b82f6;
        background-color: rgba(59, 130, 246, 0.15);
    }
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .card-shadow {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .dark .card-shadow {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
    }
    .glass-effect {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>
