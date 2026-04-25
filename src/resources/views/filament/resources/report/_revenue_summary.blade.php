<x-filament::card class="mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                Сумма выручки за выбранный месяц
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                с учётом текущих фильтров
            </p>
        </div>
        <div class="mt-2 text-xl font-semibold text-gray-900 dark:text-gray-100 sm:mt-0 sm:text-2xl">
            {{ number_format($totalRevenue, 2, ',', ' ') }} ₽
        </div>
    </div>
</x-filament::card>
