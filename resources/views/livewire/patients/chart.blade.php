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

                <x-menu-item
                        title="Edit"
                        @click="$wire.editModal = true"
                />

                <x-menu-item title="Archive" />
            </x-dropdown>
            <x-modal
                    wire:model="editModal"
                    title="Edit Patient"
                    class="backdrop-blur"
                    box-class="w-xl"
            >
                <livewire:patients.form :patient="$patient" />
            </x-modal>
        </x-slot:actions>
    </x-header>

    <div class="flex">
        <!-- DEMO -->
        <x-card
                title="Demographics"
                shadow="true"
                separator
                class="flex-1/2"
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
                    <p>{{ $patient->age }} Years Old</p>
                </div>
            </div>
        </x-card>
        <x-card
                class="flex-1/2"
                shadow="true"
                separator
                title="Notes"
        >


        </x-card>
    </div>

    <x-card
            title="Appointments"
            shadow="true"
            separator
            class="mt-4"
    >
        <x-table
                :rows="$appointments"
                :headers="$headers"
                with-pagination
        >
            @scope("cell_users", $appointment)
            @foreach($appointment->users as $user)
                <x-badge
                        :value="$user->full_name"
                        class="badge-soft"
                />
            @endforeach
            @endscope
        </x-table>
    </x-card>
</div>
