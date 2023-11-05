<x-company-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
            <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="font-medium text-xl mb-12">Projects</h3>
                <div class="relative text-gray-900 dark:text-gray-100  flex flex-wrap justify-between gap-y-8 gap-x-4">
                    @if(isset($projects))
                    @foreach($projects as $pro)

                    <div class="border-solid border-2 rounded-xl border-primary flex flex-col justify-between w-72 h-64  p-4">
                     <div class="font-medium mb-2">Project: #{{$pro->id}}</div>
                     <div class="">Client from: {{$pro->user->client->province->name}}</div>
                     <div class="">Price Range: {{$pro->price_range->name}}</div>
                     <div class="">Approximative area: {{$pro->getAttribute('aprox-area')}}</div>
                     <div class="">Deadline: {{$pro->deadline}}</div>
                    <div>
                        <a href="{{route('company.project',['id' => $pro->id])}}">
                        <x-primary-button>
                            {{ __('Details') }}
                        </x-primary-button></a></div>

                    </div>
                    @endforeach
                    @else
                         No projects at time try buying projects
                    @endif

                </div>
            </div>
        </div>
    </div>


</x-company-layout>
