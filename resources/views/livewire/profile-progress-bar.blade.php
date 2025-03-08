<div class="{{ $isFixed ? 'fixed bottom-0 left-0 right-0 z-50 bg-white/95 border-t shadow-lg' : '' }}">
    <div class="px-4 py-2">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <h4 class="text-sm font-medium text-gray-700">{{ __('profile_progress') }}</h4>
            <div class="flex items-center gap-4 flex-1 max-w-md ml-4">
                <div class="w-full bg-gray-200 rounded-full h-2 relative">
                    @foreach($detailedProgress as $section)
                        <div class="absolute h-2 transition-all duration-300 
                            @switch($section['section'])
                                @case('personalData')
                                    bg-blue-600
                                    @break
                                @case('religiousInfo')
                                    bg-green-500
                                    @break
                                @case('priestlyFormation')
                                    bg-yellow-500
                                    @break
                                @case('headOrisha')
                                    bg-purple-500
                                    @break
                                @case('workGuide')
                                    bg-pink-500
                                    @break
                                @case('forceCross')
                                    bg-indigo-500
                                    @break
                                @case('initiatedOrishas')
                                    bg-red-500
                                    @break
                            @endswitch"
                            style="left: {{ $section['position'] }}%; width: {{ $section['weight'] }}%; opacity: {{ $section['completion'] / $section['weight'] }}"
                            title="{{ __( $section['section']) }}: {{ round($section['completion'] / $section['weight']) * 100 }}%">
                        </div>
                    @endforeach
                </div>
                <span class="text-sm text-gray-600 whitespace-nowrap">{{ $progress }}%</span>
            </div>
        </div>
        {{-- <div class="flex justify-center gap-4 mt-2 text-xs">
            @foreach($detailedProgress as $section)
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 rounded-full
                        @switch($section['section'])
                            @case('personalData')
                                bg-blue-600
                                @break
                            @case('religiousInfo')
                                bg-green-500
                                @break
                            @case('priestlyFormation')
                                bg-yellow-500
                                @break
                            @case('headOrisha')
                                bg-purple-500
                                @break
                            @case('workGuide')
                                bg-pink-500
                                @break
                            @case('forceCross')
                                bg-indigo-500
                                @break
                            @case('initiatedOrishas')
                                bg-red-500
                                @break
                        @endswitch">
                    </div>
                    <span>{{ __( $section['section']) }}: {{ round($section['completion'] / $section['weight']) * 100 }}%</span>
                </div>
            @endforeach
        </div> --}}
    </div>
</div>
