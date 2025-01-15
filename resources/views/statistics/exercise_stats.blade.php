<x-app-layout>
    @vite(['resources/js/stats_chart.js'])
    
    <x-slot name="header">
        <div class="flex items-center justify-between h-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Statistiche - {{ $selectedExercise->name }}
            </h2>
        </div>
    </x-slot>

    <!-- Legend Indicator -->
<div class="flex justify-center sm:justify-end items-center gap-x-4 mb-3 sm:mb-6">
    <div class="inline-flex items-center">
      <span class="size-2.5 inline-block bg-blue-600 rounded-sm me-2"></span>
      <span class="text-[13px] text-gray-600 dark:text-neutral-400">
        Income
      </span>
    </div>
    <div class="inline-flex items-center">
      <span class="size-2.5 inline-block bg-purple-600 rounded-sm me-2"></span>
      <span class="text-[13px] text-gray-600 dark:text-neutral-400">
        Outcome
      </span>
    </div>
  </div>
  <!-- End Legend Indicator -->
  
  <div id="hs-multiple-area-charts-compare-two-tooltip-alt"></div>

</x-app-layout>
