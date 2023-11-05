<x-guest-layout>
    <form method="POST" action="{{ route('client.store') }}"  x-data='filter' x-init="fill" x-ref="form">
        @csrf
        <h2  class="capitalize text-center text-blue-950 mb-3">{{__('client registration')}}</h2>
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input x-model="name" id="name" class="block mt-1 w-full" type="text" name="name"  autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input x-model="email"  id="email" class="block mt-1 w-full" type="text"  name="email"  autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

         <!-- gover -->
         <div class="mt-4">
            <x-select x-model="gov" name="governorate" :label="__('Governorate') " required>
                <option>{{__('choose your current governorate')}}</option>

                @foreach ($governorates as $gov)
                    @if(request('gov')!==null && $gov->id===intval(request('gov')))
                        <option selected :value="{{$gov->id}}"  @click="updateUrl({{$gov->id}})">{{$gov->name}}</option>
                    @else
                    <option  :value="{{$gov->id}}"  @click="updateUrl({{$gov->id}})">{{$gov->name}}</option>
                    @endif

                @endforeach
            </x-select>
            <x-input-error :messages="$errors->get('governorate')" class="mt-2" />
        </div>

        <!-- province -->
        <div class="mt-4">
            <x-select name="province" :label="__('Province')" required>
                <option selected>{{__('choose your current province')}}</option>

                @foreach ($provinces as $prov)
                    <option :value="{{$prov->id}}">{{$prov->name}}</option>
                @endforeach


            </x-select>

            <x-input-error :messages="$errors->get('province')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                             autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"  autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>



        <div class="flex items-center justify-end mt-4" >
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
<script>
        document.addEventListener('alpine:init', () => {
        Alpine.data('filter', () => ({
    name: '',
    email: '',
    gov: '',
    oldName: '',
    oldEmail: '',
    fill() {
        console.log(this.oldEmail);
        const currentUrl = window.location.href;
        const urlParams = new URLSearchParams(currentUrl);
        if(this.oldName !== "" || this.oldEmail !== "") {
            this.name=this.oldName;
             this.email=this.oldEmail;}
        else if (this.name === '' && urlParams.has('name')) {
            this.name = urlParams.get('name');
        }
        if (this.email === '' && urlParams.has('email')) {
            this.email = urlParams.get('email');
        }
    },
    updateUrl(id) {
        const currentUrl = window.location.href;
        const baseUrl = currentUrl.split('?')[0];
        const newUrl = `${baseUrl}?gov=${id}&name=${this.name}&email=${this.email}`;
        window.location.href = newUrl;
    },
            }))

        })
</script>
