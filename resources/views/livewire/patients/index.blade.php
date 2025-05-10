<div>
    <!-- HEADER -->
    <x-header
            title="Patient List"
            separator
            progress-indicator
    >
        <x-slot:middle class="!justify-end">
            <div class="flex">


            <x-input
                    placeholder="Search..."
                    wire:model.live.debounce="search"
                    clearable
                    icon="o-magnifying-glass"
            /></div>
        </x-slot:middle>
        <x-slot:actions>
            <x-dropdown>
                <x-slot:trigger>
                    <x-button
                            icon="o-adjustments-horizontal"
                            class="btn-adjustments-horizontal"
                    />
                </x-slot:trigger>

                <x-menu-item title="Add New" @click="$wire.addModal = true" />
            </x-dropdown>
            <x-modal wire:model="addModal" title="Add New Patient" class="backdrop-blur" box-class="w-xl">
                <livewire:patients.form />
            </x-modal>
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

</div>
