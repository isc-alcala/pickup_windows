
        <div x-show="isOpen" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl">
            <header class="flex justify-end">
                <button wire:click="closeModal" class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 7.293l-5.293-5.293-1.414 1.414L8.586 10 3.293 15.293l1.414 1.414L10 11.414l5.293 5.293 1.414-1.414L11.414 10l5.293-5.293-1.414-1.414L10 8.586l-5.293-5.293 1.414-1.414L10 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </header>

            <div class="mt-4 mb-6">
                <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                    Update Truck Status
                </p>
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Description</span>
                            <textarea wire:model="description" class="block w-full mt-1 text-sm form-textarea dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"></textarea>
                        </label>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

