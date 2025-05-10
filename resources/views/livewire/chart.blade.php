<div>
    <!-- HEADER -->
    <x-header
            separator
            progress-indicator
    >
        <x-slot:title>
            {{ $patient->full_name }} (#{{$patient->id}})
        </x-slot:title>
        <x-slot:subtitle>
            DOB: {{ $patient->dob_short }}
        </x-slot:subtitle>
        <x-slot:middle class="!justify-end">

        </x-slot:middle>
        <x-slot:actions>
            <x-dropdown>
                <x-slot:trigger>
                    <x-button
                            icon="o-adjustments-horizontal"
                            class="btn-adjustments-horizontal"
                    />
                </x-slot:trigger>

                <x-menu-item title="Edit" @click="$wire.editModal = true" />

                <x-menu-item title="Archive" />
            </x-dropdown>
            <x-modal wire:model="editModal" title="Edit Patient" class="backdrop-blur" box-class="w-xl">
                <livewire:patients.form :patient="$patient" />
            </x-modal>
        </x-slot:actions>
    </x-header>

    <x-card
            title="Demographics"
            shadow="true"
    >
        <div class="flex">
            <img
                    src="{{ $patient->avatar }}"
                    alt="Picture"
                    class="w-24 h-24 rounded shadow-xs saturate-50 hover:saturate-100 hover:shadow-none border-neutral-content/30 border shrink-0 mr-4"
            />
            <div>
                <p>{{ $patient->gender }}</p>
                <p>{{ $patient->email }}</p>
            </div>
        </div>
    </x-card>
</div>
