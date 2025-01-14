<x-app-layout>
    <x-modal name="add" maxWidth="max-w-[96rem]">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Aggiungi esercizio
                </h3>

                <button type="button" class="bg-transparent hover:bg-gray-200 rounded-lg w-7 h-7 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" x-on:click.prevent="$dispatch('close-modal', 'add')">
                    <x-mdi-close class="w-6 fill-gray-400" />
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 justify-center z-50 w-full">
                <livewire:workout_plans.add-exercise-modal :workout_plan="$workout_plan" />
            </div>
        </div>
    </x-modal>

    <x-modal name="edit">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Modifica esercizio
                </h3>

                <button type="button" class="bg-transparent hover:bg-gray-200 rounded-lg w-7 h-7 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" x-on:click.prevent="$dispatch('close-modal', 'edit')">
                    <x-mdi-close class="w-6 fill-gray-400" />
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 justify-center z-50 w-full">
                <livewire:workout_plans.edit-exercise-modal :workout_plan="$workout_plan" />
            </div>
        </div>
    </x-modal>

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