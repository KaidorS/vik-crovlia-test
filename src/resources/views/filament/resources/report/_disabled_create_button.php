<div
    x-data="countdownTimer()"
    x-init="init()"
    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed dark:bg-gray-800 dark:text-gray-400"
>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span>Создать отчёт можно через</span>
    <span x-text="timeString" class="font-mono font-bold"></span>
</div>

<script>
    function countdownTimer() {
        return {
            timeString: '',
            init() {
                this.updateTimer();
                setInterval(() => this.updateTimer(), 60000);
            },
            updateTimer() {
                const now = new Date();
                // Следующая полуночь по Москве (UTC+3)
                const mskOffset = 3;
                const nextMidnight = new Date(Date.UTC(
                    now.getUTCFullYear(),
                    now.getUTCMonth(),
                    now.getUTCDate() + 1,
                    0 - mskOffset,
                    0,
                    0
                ));
                const diffMs = nextMidnight - now;
                if (diffMs <= 0) {
                    location.reload();
                    return;
                }
                const hours = Math.floor(diffMs / (1000 * 60 * 60));
                const minutes = Math.floor((diffMs % (3600000)) / 60000);
                this.timeString = `${hours.toString().padStart(2,'0')}:${minutes.toString().padStart(2,'0')}`;
            }
        }
    }
</script>
