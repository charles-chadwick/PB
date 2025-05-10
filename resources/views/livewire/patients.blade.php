<div>
    <!-- HEADER -->
    <x-header
            title="Hello"
            separator
            progress-indicator
    >
        <x-slot:middle class="!justify-end">
            <x-input
                    placeholder="Search..."
                    wire:model.live.debounce="search"
                    clearable
                    icon="o-magnifying-glass"
            />
        </x-slot:middle>
        <x-slot:actions>
            <x-button
                    label="Filters"
                    @click="$wire.drawer = true"
                    responsive
                    icon="o-funnel"
                    class="btn-primary"
            />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-table
                :headers="$headers"
                :rows="$patients"
                :sort-by="$sortBy"
                striped
                with-pagination
        >
            @scope('cell_id', $patient)
            <a href="{{ route('chart', $patient) }}">{{ $patient->id }}</a>
            @endscope

            @scope('cell_first_name', $patient)
            <a href="{{ route('chart', $patient) }}">{{ $patient->first_name }}</a>
            @endscope

            @scope('cell_last_name', $patient)
            <a href="{{ route('chart', $patient) }}">{{ $patient->last_name }}</a>
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer
            wire:model="drawer"
            title="Filters"
            right
            separator
            with-close-button
            class="lg:w-1/3"
    >
        <x-input
                placeholder="Search..."
                wire:model.live.debounce="search"
                icon="o-magnifying-glass"
                @keydown.enter="$wire.drawer = false"
        />

        <x-slot:actions>
            <x-button
                    label="Reset"
                    icon="o-x-mark"
                    wire:click="clear"
                    spinner
            />
            <x-button
                    label="Done"
                    icon="o-check"
                    class="btn-primary"
                    @click="$wire.drawer = false"
            />
        </x-slot:actions>
    </x-drawer>
</div>
