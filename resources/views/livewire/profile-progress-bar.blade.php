<div class="{{ $isFixed ? 'fixed bottom-0 left-0 right-0 z-50 bg-white/95 border-t shadow-lg' : '' }}">
    <div class="px-4 py-2">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <h4 class="text-sm font-medium text-gray-700">Progresso do seu cadastro</h4>
            <div class="flex items-center gap-4 flex-1 max-w-md ml-4">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                </div>
                <span class="text-sm text-gray-600 whitespace-nowrap">{{ $progress }}%</span>
            </div>
        </div>
    </div>
</div>
