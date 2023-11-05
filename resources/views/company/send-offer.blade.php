  <x-guest-layout>
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-control w-full max-w-xs" x-bind:x-show=>
            <label class="label" for="contract_file">
            <span class="label-text font-medium">Offer Value</span>
            </label>
             <x-text-input id="offer_value" class="block mt-1 w-full"
                            type="number"
                            name="offer_value" />

            <x-input-error :messages="$errors->get('offer_value')" class="mt-2" />
        </div>

        <div class="form-control w-full max-w-xs mt-4" x-bind:x-show=>
            <label class="label" for="contract_file">
            <span class="label-text font-medium">Contract File</span>
            </label>
            <input name="contract_file" type="file" class="file-input file-input-bordered file-input-primary w-full max-w-xs" />
            <x-input-error :messages="$errors->get('contract_file"')" class="mt-2" />
        </div>

        <div class="flex mr-6 items-center mt-4 ">
        <input name="is_accurate" type="checkbox" class="checkbox checkbox-primary  mr-4"/>
        <label for="is_accurate" class="label">
            <span class="label-text font-medium">Detail Design included</span>
        </label>
        </div>
        <div class="mt-4">
            <x-primary-button>
            {{ __('Send Offer') }}
        </x-primary-button></div>
    </form>
</x-guest-layout>
