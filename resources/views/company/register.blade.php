<x-guest-layout>
    <form method="POST" action="{{ route('company.store') }}"  x-data='filter' x-init="fill" x-ref="form" enctype="multipart/form-data">
        @csrf
        <h2  class="capitalize text-center text-blue-950 mb-3">{{__('company registration')}}</h2>
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Company name')" />
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

        <!-- Category Input -->
        <div class="mt-4">
            <x-select name="category_id" :label="__('Category')" required>
                <option selected>{{__('choose your company category')}}</option>

                @foreach ($categories as $cat)
                    <option :value="{{$cat->id}}">{{$cat->name}}</option>
                @endforeach


            </x-select>

            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>

        <!-- Contact Address Input -->
        <div class="mt-12">
            <x-input-label for="contact_address" :value="__('Contact Address')" />
            <x-text-input id="contact_address" class="block mt-1 w-full" type="text" name="contact_address" :value="old('contact_address')" />
            <x-input-error :messages="$errors->get('contact_address')" class="mt-2" />
        </div>

        <!-- Contact Email Input -->
        <div class="mt-4">
            <x-input-label for="contact_email" :value="__('Contact Email')" />
            <x-text-input id="contact_email" class="block mt-1 w-full" type="email" name="contact_email" :value="old('contact_email')" />
            <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
        </div>

        <!-- Contact Phone Input -->
        <div class="mt-4">
            <x-input-label for="contact_phone" :value="__('Contact Phone')" />
            <x-text-input id="contact_phone" class="block mt-1 w-full" type="tel" name="contact_phone" :value="old('contact_phone')" />
            <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
        </div>

        <!-- Contact Website Input -->
        <div class="mt-4">
            <x-input-label for="contact_website" :value="__('Contact Website')" />
            <x-text-input id="contact_website" class="block mt-1 w-full" type="url" name="contact_website" :value="old('contact_website')" />
            <x-input-error :messages="$errors->get('contact_website')" class="mt-2" />
        </div>

        <!-- Company File Input -->
        <div class="mt-12">
            <x-input-label for="company_file" :value="__('Company File')" />
            <input id="company_file" class="file-input file-input-bordered file-input-primary w-full max-w-xs" type="file" name="company_file" />
            <x-input-error :messages="$errors->get('company_file')" class="mt-2" />
        </div>


        <!-- Password -->
        <div class="mt-12">
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
