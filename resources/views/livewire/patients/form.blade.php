<x-form wire:submit.prevent="save">

    <div class="grid grid-cols-3 gap-x-2">
        <div>
            <x-input
                    label="First Name"
                    wire:model="first_name"
                    placeholder="First Name"

            />
        </div>
        <div>
            <x-input
                    label="Middle Name"
                    wire:model="middle_name"
                    placeholder="Middle Name"

            />
        </div>
        <div>
            <x-input
                    label="Last Name"
                    wire:model="last_name"
                    placeholder="Last Name"

            />
        </div>
    </div>

    <div class="grid grid-cols-2 gap-x-2">
        <div>
            <x-input
                    label="Email"
                    wire:model="email"
                    placeholder="Email"

            />
        </div>

        <div>
            <x-input
                    label="Date of Birth"
                    wire:model="dob"
                    placeholder="Date of Birth"

            />
        </div>
        <div>
            <x-select
                    label="Gender"
                    wire:model="gender"
                    :options="$genders"

            />
        </div>

    </div>
    <x-button label="Save" class="btn-primary" type="submit" spinner="save" />

</x-form>