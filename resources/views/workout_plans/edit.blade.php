<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex items-center justify-center p-0 py-4 sm:p-4">
                <div class="w-full sm:w-5/6 mx-auto grid grid-cols-1 gap-4">
                    <livewire:workout_plans.workout-editor :workout_plan="$workout_plan" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>